<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Appointment;
use App\Models\AppointmentStatusHistory;
use App\Models\ClientAddress;
use App\Models\Client;
use App\Models\Service;
use App\Models\VehicleType;
use App\Models\ExtraService;

class AppointmentAdminController extends Controller
{
    /**
     * Estados válidos para citas.
     */
    private const VALID_STATUSES = [
        'Pending',
        'Accepted',
        'Rejected',
        'Completed',
    ];

    /**
     * Mostrar listado de citas (paginado, con filtro por estado opcional).
     * Además, para cada cita agregamos un atributo "scheduled_local"
     * en zona "America/Los_Angeles" para que el front pueda usarlo
     * directamente al pasar el modelo al blade (Js::from).
     */
    public function index(Request $request)
    {
        $statusFilter = $request->query('status');

        // Eager-load de todas las relaciones que luego usa el modal View y el modal Edit:
        // - client
        // - service.category (para mostrar la categoría del servicio)
        // - vehicleType
        // - address
        // - extraServices.extraService (para mostrar nombre, cantidad y precio)
        // - updatedByAdmin (para saber quién creó/modificó)
        // - statusHistories.changedByAdmin (para el historial de cambios de estado)
        $query = Appointment::with([
                'client',
                'service.category',
                'vehicleType',
                'address',
                'extraServices.extraService',
                'updatedByAdmin',
                'statusHistories.changedByAdmin',
            ])
            ->orderBy('scheduled_at', 'desc');

        if ($statusFilter && in_array($statusFilter, self::VALID_STATUSES, true)) {
            $query->where('status', $statusFilter);
        }

        $appointments = $query->paginate(10);

        // Convertir scheduled_at (UTC) a zona local y guardarlo como "scheduled_local"
        $appointments->getCollection()->transform(function (Appointment $appointment) {
            $local = $appointment
                ->scheduled_at
                ->setTimezone('America/Los_Angeles')
                ->format('Y-m-d H:i:s');

            $appointment->scheduled_local = $local;
            return $appointment;
        });

        $clients       = Client::orderBy('last_name')->orderBy('first_name')->get();
        $services      = Service::orderBy('name')->get();
        $vehicleTypes  = VehicleType::orderBy('name')->get();
        $extraServices = ExtraService::orderBy('name')->get();
        $statuses      = self::VALID_STATUSES;

        return view('admin.appointments.index', compact(
            'appointments',
            'statusFilter',
            'clients',
            'services',
            'vehicleTypes',
            'extraServices',
            'statuses'
        ));
    }

    /**
     * (Opcional) Si quisieras mostrar una página independiente de creación.
     * En este proyecto probablemente uses un modal dentro de index(), así que puede no usarse.
     */
    public function create()
    {
        $clients       = Client::orderBy('last_name')->orderBy('first_name')->get();
        $services      = Service::orderBy('name')->get();
        $vehicleTypes  = VehicleType::orderBy('name')->get();
        $extraServices = ExtraService::orderBy('name')->get();
        $statuses      = self::VALID_STATUSES;

        return view('admin.appointments.create_page_fallback', compact(
            'clients',
            'services',
            'vehicleTypes',
            'extraServices',
            'statuses'
        ));
    }

    /**
     * Validar y guardar una nueva cita desde el formulario (o modal) de Admin.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id'           => 'required|exists:clients,id',
            'address_street'      => 'required|string|max:255',
            'address_city'        => 'required|string|max:100',
            'address_state'       => 'nullable|string|max:100',
            'address_postal_code' => 'nullable|string|max:20',
            'service_id'          => 'required|exists:services,id',
            'vehicle_type_id'     => 'required|exists:vehicle_types,id',
            'scheduled_at_date'   => 'required|date',
            'scheduled_at_time'   => 'required|date_format:H:i',
            'monto_final'         => 'required|numeric|min:0',
            'status'              => 'required|in:' . implode(',', self::VALID_STATUSES),
            'extras'              => 'nullable|array',
            'extras.*'            => 'exists:extra_services,id',
            'notas'               => 'nullable|string',
        ]);

        // 1) Crear nueva dirección del cliente
        $clientAddress = ClientAddress::create([
            'client_id'   => $validatedData['client_id'],
            'street'      => $validatedData['address_street'],
            'city'        => $validatedData['address_city'],
            'state'       => $validatedData['address_state'],
            'postal_code' => $validatedData['address_postal_code'],
        ]);

        // 2) Combinar fecha + hora en zona local (America/Los_Angeles) y convertir a UTC
        $userTz       = 'America/Los_Angeles';
        $fechaHoraStr = "{$validatedData['scheduled_at_date']} {$validatedData['scheduled_at_time']}";
        $scheduledAt = Carbon::createFromFormat('Y-m-d H:i', $fechaHoraStr, $userTz)
                            ->setTimezone('UTC');

        // 3) Crear Appointment
        $appointment = Appointment::create([
            'client_id'           => $validatedData['client_id'],
            'address_id'          => $clientAddress->id,
            'service_id'          => $validatedData['service_id'],
            'vehicle_type_id'     => $validatedData['vehicle_type_id'],
            'scheduled_at'        => $scheduledAt,
            'monto_final'         => $validatedData['monto_final'],
            'status'              => $validatedData['status'],
            'notas'               => $validatedData['notas'] ?? null,
            'updated_by_admin_id' => Auth::guard('admin')->id(),
        ]);

        // 4) Guardar servicios extra usando la relación del modelo (extraServices())
        if (!empty($validatedData['extras'])) {
            foreach ($validatedData['extras'] as $extraId) {
                $extraService = ExtraService::find($extraId);
                if ($extraService) {
                    $appointment->extraServices()->create([
                        'extra_service_id' => $extraService->id,
                        'quantity'         => 1,
                        'unit_price'       => $extraService->price,
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Appointment created successfully!');
    }

    /**
     * Mostrar detalles de una cita en una vista /show (si se usa).
     * (Aunque generalmente usamos el modal, lo dejamos para referencia.)
     */
    public function show(Appointment $appointment)
    {
        $appointment->load([
            'client',
            'address',
            'service.category',
            'vehicleType',
            'extraServices.extraService',
            'updatedByAdmin',
            'statusHistories.changedByAdmin',
        ]);

        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Preparar datos para editar una cita (redirige a index con datos en sesión).
     * Usamos un modal en index(), así que pasamos $appointment a sesión y 
     * redirigimos con una bandera para “abrir el modal de edición”.
     */
    public function edit(Appointment $appointment)
    {
        $clients       = Client::orderBy('last_name')->orderBy('first_name')->get();
        $services      = Service::orderBy('name')->get();
        $vehicleTypes  = VehicleType::orderBy('name')->get();
        $extraServices = ExtraService::orderBy('name')->get();
        $statuses      = self::VALID_STATUSES;

        // Cargamos todas las relaciones necesarias (para rellenar el formulario):
        $appointment->load([
            'client',
            'address',
            'service',
            'vehicleType',
            'extraServices.extraService',
        ]);

        // Convertir scheduled_at (UTC) a local para rellenar el form de fecha/hora
        $localDate = $appointment->scheduled_at
                        ->setTimezone('America/Los_Angeles')
                        ->format('Y-m-d');
        $localTime = $appointment->scheduled_at
                        ->setTimezone('America/Los_Angeles')
                        ->format('H:i');
        $appointment->scheduled_at_date = $localDate;
        $appointment->scheduled_at_time = $localTime;

        // IDs de extras existentes, para marcar checkbox en el form
        $appointment->extrasArray = $appointment->extraServices
            ->map(fn($es) => (string) $es->extra_service_id)
            ->toArray();

        // Pasar todo a la sesión para luego abrir el modal de edición en index
        return redirect()
            ->route('admin.appointments.index')
            ->with('open_edit_modal', true)
            ->with('appointment_to_edit_on_error', $appointment)
            ->with(compact('clients', 'services', 'vehicleTypes', 'extraServices', 'statuses'));
    }

    /**
     * Validar y actualizar datos de una cita existente.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validatedData = $request->validate([
            'client_id'           => 'required|exists:clients,id',
            'address_street'      => 'required|string|max:255',
            'address_city'        => 'required|string|max:100',
            'address_state'       => 'nullable|string|max:100',
            'address_postal_code' => 'nullable|string|max:20',
            'service_id'          => 'required|exists:services,id',
            'vehicle_type_id'     => 'required|exists:vehicle_types,id',
            'scheduled_at_date'   => 'required|date',
            'scheduled_at_time'   => 'required|date_format:H:i',
            'monto_final'         => 'required|numeric|min:0',
            'status'              => 'required|in:' . implode(',', self::VALID_STATUSES),
            'extras'              => 'nullable|array',
            'extras.*'            => 'exists:extra_services,id',
            'notas'               => 'nullable|string',
        ]);

        // 1) Crear nueva dirección (para histórico de direcciones)
        $clientAddress = ClientAddress::create([
            'client_id'   => $validatedData['client_id'],
            'street'      => $validatedData['address_street'],
            'city'        => $validatedData['address_city'],
            'state'       => $validatedData['address_state'],
            'postal_code' => $validatedData['address_postal_code'],
        ]);

        // 2) Combinar fecha + hora en zona local y convertir a UTC
        $userTz       = 'America/Los_Angeles';
        $fechaHoraStr = "{$validatedData['scheduled_at_date']} {$validatedData['scheduled_at_time']}";
        $scheduledAt  = Carbon::createFromFormat('Y-m-d H:i', $fechaHoraStr, $userTz)
                              ->setTimezone('UTC');

        DB::beginTransaction();
        try {
            // 3) Actualizar datos de la cita
            $appointment->update([
                'client_id'           => $validatedData['client_id'],
                'address_id'          => $clientAddress->id,
                'service_id'          => $validatedData['service_id'],
                'vehicle_type_id'     => $validatedData['vehicle_type_id'],
                'scheduled_at'        => $scheduledAt,
                'monto_final'         => $validatedData['monto_final'],
                'status'              => $validatedData['status'],
                'notas'               => $validatedData['notas'] ?? null,
                'updated_by_admin_id' => Auth::guard('admin')->id(),
            ]);

            // 4) Eliminar servicios extra anteriores y recrear
            $appointment->extraServices()->delete();
            if (!empty($validatedData['extras'])) {
                foreach ($validatedData['extras'] as $extraId) {
                    $extraService = ExtraService::find($extraId);
                    if ($extraService) {
                        $appointment->extraServices()->create([
                            'extra_service_id' => $extraService->id,
                            'quantity'         => 1,
                            'unit_price'       => $extraService->price,
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->back()
                ->withErrors('Error updating appointment: ' . $e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Appointment updated successfully!');
    }

    /**
     * Eliminar una cita.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    /**
     * Actualizar únicamente el estado de la cita (PATCH).
     * Si la petición es AJAX (wantsJson), devuelve JSON; sino redirige.
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'new_status' => 'required|in:' . implode(',', self::VALID_STATUSES),
        ]);

        $oldStatus = $appointment->status;
        $newStatus = $data['new_status'];

        // Si no cambió, devolver mensaje
        if ($oldStatus === $newStatus) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Status unchanged.',
                    'status'  => $oldStatus,
                ], 200);
            }
            return redirect()->back()->with('info', 'The status has not changed.');
        }

        DB::beginTransaction();
        try {
            // 1) Actualizar el estado en la tabla appointments
            $appointment->update([
                'status'              => $newStatus,
                'updated_by_admin_id' => Auth::guard('admin')->id(),
            ]);

            // 2) Registrar el cambio en el historial
            AppointmentStatusHistory::create([
                'appointment_id'      => $appointment->id,
                'old_status'          => $oldStatus,
                'new_status'          => $newStatus,
                'changed_by_admin_id' => Auth::guard('admin')->id(),
                'changed_at'          => now(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => 'Error updating status: ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->withErrors('Error updating status: ' . $e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message'    => 'Status updated successfully.',
                'new_status' => $newStatus,
            ], 200);
        }

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Appointment status updated to ' . $newStatus);
    }

    /**
     * Devolver detalles de una cita en JSON (para el modal de calendario o View).
     * Carga todas las relaciones necesarias que tu modal usa:
     * - client
     * - service.category
     * - vehicleType
     * - address
     * - extraServices.extraService
     * - updatedByAdmin
     * - statusHistories.changedByAdmin
     * Además, agrega "scheduled_local" en zona America/Los_Angeles.
     */
    public function getAppointmentJsonDetails(Appointment $appointment)
    {
        // Cargar relaciones faltantes
        $appointment->loadMissing([
            'client',
            'service.category',
            'vehicleType',
            'address',
            'extraServices.extraService',
            'updatedByAdmin',
            'statusHistories.changedByAdmin',
        ]);

        // Convertir scheduled_at (UTC) a local
        $localScheduled = $appointment
            ->scheduled_at
            ->setTimezone('America/Los_Angeles')
            ->format('Y-m-d H:i:s');

        // Transformar el modelo a array, luego agregar scheduled_local
        $payload = array_merge(
            $appointment->toArray(),
            ['scheduled_local' => $localScheduled]
        );

        return response()->json($payload);
    }

    /**
     * Devolver eventos en JSON para FullCalendar.
     * Recibe 'start' y 'end' en query string (YYYY-MM-DD).
     */
    public function calendarEvents(Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'end'   => 'required|date|after_or_equal:start',
        ]);

        $startRange = Carbon::parse($request->input('start'))->startOfDay();
        $endRange   = Carbon::parse($request->input('end'))->endOfDay();

        $appointments = Appointment::with(['client', 'service'])
            ->whereBetween('scheduled_at', [$startRange, $endRange])
            ->get();

        $events = $appointments->map(function (Appointment $appointment) {
            // Convertir cada cita de UTC a zona local (America/Los_Angeles),
            // y formatear sin offset para que FullCalendar la interprete como hora local.
            $startLocal = $appointment->scheduled_at
                ->setTimezone('America/Los_Angeles')
                ->format('Y-m-d\TH:i:s');
            $endLocal = Carbon::parse($appointment->scheduled_at)
                ->setTimezone('America/Los_Angeles')
                ->addHour()
                ->format('Y-m-d\TH:i:s');

            // Colores basados en estado
            $color     = '#3498db'; // Azul por defecto
            $textColor = '#FFFFFF';
            $statusKey = strtolower($appointment->status);

            switch ($statusKey) {
                case 'pending':
                    $color     = '#f1c40f'; // Amarillo
                    $textColor = '#333333';
                    break;
                case 'accepted':
                case 'scheduled':
                    $color = '#2ecc71'; // Verde
                    break;
                case 'rejected':
                    $color = '#e74c3c'; // Rojo
                    break;
                case 'completed':
                    $color = '#34495e'; // Azul oscuro / gris
                    break;
                default:
                    $color     = '#bdc3c7'; // Gris claro
                    $textColor = '#333333';
            }

            return [
                'id'              => $appointment->id,
                'calendarId'      => 'appointments',
                'title'           => ($appointment->client
                    ? $appointment->client->first_name . ' ' . $appointment->client->last_name
                    : 'N/A Client')
                    . ' – '
                    . ($appointment->service
                        ? $appointment->service->name
                        : 'N/A Service'),
                'start'           => $startLocal,    // e.g. "2025-06-01T12:00:00"
                'end'             => $endLocal,      // e.g. "2025-06-01T13:00:00"
                'backgroundColor' => $color,
                'borderColor'     => $color,
                'textColor'       => $textColor,
                'isReadOnly'      => true,
                'raw'             => [
                    'appointment_id' => $appointment->id,
                    'status'         => $appointment->status,
                    'clientName'     => $appointment->client
                        ? $appointment->client->first_name . ' ' . $appointment->client->last_name
                        : 'N/A',
                    'serviceName'    => $appointment->service
                        ? $appointment->service->name
                        : 'N/A',
                ],
            ];
        });

        return response()->json($events);
    }
}