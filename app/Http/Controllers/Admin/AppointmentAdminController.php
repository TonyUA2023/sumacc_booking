<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\AppointmentStatusHistory;
use App\Models\ClientAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Service;
use App\Models\VehicleType;
use App\Models\ExtraService;
use Carbon\Carbon;

class AppointmentAdminController extends Controller
{
    /**
     * Estados válidos para citas.
     */
    private const VALID_STATUSES = [
        'Pending',
        'Accepted',
        'Confirmed',
        'Scheduled',
        'In Progress',
        'Completed',
        'Cancelled',
        'Rejected',
    ];

    /**
     * Mostrar listado de citas (paginado, con filtro por estado opcional).
     */
    public function index(Request $request)
    {
        $statusFilter = $request->query('status');

        $query = Appointment::with(['client', 'service', 'vehicleType', 'updatedByAdmin'])
            ->orderBy('scheduled_at', 'desc');

        if ($statusFilter && in_array($statusFilter, self::VALID_STATUSES, true)) {
            $query->where('status', $statusFilter);
        }

        $appointments = $query->paginate(10);

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
     * Mostrar formulario de creación (si se usa vista independiente).
     * En este proyecto suele usarse modal dentro de index(), por lo que podría no usarse.
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
     * Validar y guardar una nueva cita desde el formulario de Admin (o modal).
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

        // Crear nueva dirección del cliente
        $clientAddress = ClientAddress::create([
            'client_id'   => $validatedData['client_id'],
            'street'      => $validatedData['address_street'],
            'city'        => $validatedData['address_city'],
            'state'       => $validatedData['address_state'],
            'postal_code' => $validatedData['address_postal_code'],
        ]);

        // Combinar fecha y hora para campo datetime
        $scheduledAt = Carbon::parse("{$validatedData['scheduled_at_date']} {$validatedData['scheduled_at_time']}");

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

        // Guardar servicios extra si se seleccionaron
        if (!empty($validatedData['extras'])) {
            foreach ($validatedData['extras'] as $extraId) {
                $extraService = ExtraService::find($extraId);
                if ($extraService) {
                    \App\Models\AppointmentExtraService::create([
                        'appointment_id'   => $appointment->id,
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
     * Mostrar detalles de una cita (vista separada).
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
            'statusHistories'
        ]);

        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Preparar datos para editar una cita (redirige a index con datos en sesión).
     */
    public function edit(Appointment $appointment)
    {
        $clients       = Client::orderBy('last_name')->orderBy('first_name')->get();
        $services      = Service::orderBy('name')->get();
        $vehicleTypes  = VehicleType::orderBy('name')->get();
        $extraServices = ExtraService::orderBy('name')->get();
        $statuses      = self::VALID_STATUSES;

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

        // Crear nueva dirección
        $clientAddress = ClientAddress::create([
            'client_id'   => $validatedData['client_id'],
            'street'      => $validatedData['address_street'],
            'city'        => $validatedData['address_city'],
            'state'       => $validatedData['address_state'],
            'postal_code' => $validatedData['address_postal_code'],
        ]);

        $scheduledAt = Carbon::parse("{$validatedData['scheduled_at_date']} {$validatedData['scheduled_at_time']}");

        DB::beginTransaction();
        try {
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

            // Eliminar registros previos de servicios extra y volver a crear
            $appointment->extraServices()->delete();
            if (!empty($validatedData['extras'])) {
                foreach ($validatedData['extras'] as $extraId) {
                    $extraService = ExtraService::find($extraId);
                    if ($extraService) {
                        \App\Models\AppointmentExtraService::create([
                            'appointment_id'   => $appointment->id,
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
     * Actualizar únicamente el estado de la cita.
     * Si la petición es AJAX, devuelve JSON; de lo contrario, redirige.
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'new_status' => 'required|in:' . implode(',', self::VALID_STATUSES),
        ]);

        $oldStatus = $appointment->status;
        $newStatus = $data['new_status'];

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
            $appointment->update([
                'status'              => $newStatus,
                'updated_by_admin_id' => Auth::guard('admin')->id(),
            ]);

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
                'message' => 'Status updated successfully.',
                'new_status' => $newStatus,
            ], 200);
        }

        return redirect()
            ->route('admin.appointments.show', $appointment->id)
            ->with('success', 'Appointment status updated to ' . $newStatus);
    }

    /**
     * Devolver detalles de una cita en JSON (para el modal de calendario).
     */
    public function getAppointmentJsonDetails(Appointment $appointment)
    {
        $appointment->loadMissing([
            'client',
            'service',
            'vehicleType',
            'address',
            'extraServices.extraService',
        ]);

        return response()->json($appointment);
    }

    /**
     * Devolver eventos en JSON para Toast UI Calendar (o FullCalendar).
     * Recibe 'start' y 'end' en query string (ISO dates).
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
            $color      = '#3498db'; // Azul por defecto
            $textColor  = '#FFFFFF';
            $category   = 'time';     // Para eventos con hora de inicio y fin en Toast UI
            $statusKey  = strtolower($appointment->status);

            switch ($statusKey) {
                case 'pending':
                    $color     = '#f1c40f'; // Amarillo
                    $textColor = '#333333';
                    break;
                case 'accepted':
                case 'confirmed':
                case 'scheduled':
                    $color = '#2ecc71'; // Verde
                    break;
                case 'rejected':
                case 'cancelled':
                    $color = '#e74c3c'; // Rojo
                    break;
                case 'in progress':
                    $color = '#9b59b6'; // Morado
                    break;
                case 'completed':
                    $color = '#34495e'; // Azul oscuro/gris
                    break;
                default:
                    $color     = '#bdc3c7'; // Gris claro
                    $textColor = '#333333';
            }

            // Duración fija 1h
            $eventEnd = Carbon::parse($appointment->scheduled_at)->addHour();

            return [
                'id'              => 'appointment-' . $appointment->id,
                'calendarId'      => 'appointments',
                'title'           => ($appointment->client
                                        ? $appointment->client->first_name . ' ' . $appointment->client->last_name
                                        : 'N/A Client')
                                    . ' - '
                                    . ($appointment->service
                                        ? $appointment->service->name
                                        : 'N/A Service'),
                'category'        => $category,
                'start'           => $appointment->scheduled_at->toIso8601String(),
                'end'             => $eventEnd->toIso8601String(),
                'isReadOnly'      => true,
                'backgroundColor' => $color,
                'borderColor'     => $color,
                'color'           => $textColor,
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