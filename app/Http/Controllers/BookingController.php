<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientAddress;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\VehicleType;
use App\Models\ExtraService;
use App\Models\Appointment;
use App\Models\AppointmentExtraService;
use App\Models\ServiceVehiclePrice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    // ... (tu método create existente, sin cambios aquí)
    public function create(Service $service)
    {
        $vehicleTypes = VehicleType::all();
        $extraServices = ExtraService::all();

        $serviceVehiclePrices = ServiceVehiclePrice::where('service_id', $service->id)
            ->pluck('price', 'vehicle_type_id');

        $extraServiceDetails = $extraServices->mapWithKeys(function ($item) {
            return [$item->id => ['name' => $item->name, 'price' => $item->price]];
        });

        return view('booking.create', [
            'service'               => $service,
            'vehicleTypes'          => $vehicleTypes,
            'extraServices'         => $extraServices,
            'serviceVehiclePrices'  => $serviceVehiclePrices,
            'extraServiceDetails'   => $extraServiceDetails,
        ]);
    }

        public function store(Request $request)
    {
        $targetTimezone = 'America/Los_Angeles'; // Zona horaria de Seattle

        $validator = Validator::make($request->all(), [
            'service_id'        => 'required|exists:services,id',
            'vehicle_type_id'   => 'required|exists:vehicle_types,id',
            'extras'            => 'array|nullable',
            'extras.*'          => 'exists:extra_services,id',
            'date'              => 'required|date_format:Y-m-d', // Validación de fecha
            'time'              => 'required|date_format:H:i',   // Validación de hora
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'email'             => 'required|email|max:255',
            'phone'             => 'required|string|max:30',
            'street'            => 'required|string|max:255',
            'city'              => 'required|string|max:100',
            'state'             => 'nullable|string|max:100',
            'postal_code'       => 'nullable|string|max:20',
            'notes'             => 'nullable|string|max:1000',
        ]);

        // Validación personalizada para la fecha y hora combinadas (para 'after_or_equal:today' en la zona correcta)
        $validator->after(function ($validator) use ($request, $targetTimezone) {
            if ($request->filled('date') && $request->filled('time')) {
                try {
                    $selectedDateTimeSeattle = Carbon::createFromFormat(
                        'Y-m-d H:i',
                        $request->input('date') . ' ' . $request->input('time'),
                        $targetTimezone
                    );
                    $nowInSeattle = Carbon::now($targetTimezone)->startOfMinute(); // Comparar con el inicio del minuto actual

                    if ($selectedDateTimeSeattle->lt($nowInSeattle)) {
                        $validator->errors()->add('time', 'The selected date and time cannot be in the past (Seattle Time).');
                    }
                } catch (\Exception $e) {
                    $validator->errors()->add('date', 'The date or time format is invalid.');
                }
            }
        });


        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        return DB::transaction(function () use ($validated, $targetTimezone) {
            $client = Client::updateOrCreate(
                ['email' => $validated['email']],
                [
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'phone' => $validated['phone'],
                ]
            );

            $clientAddress = ClientAddress::create([
                'client_id'   => $client->id,
                'street'      => $validated['street'],
                'city'        => $validated['city'],
                'state'       => $validated['state'] ?? null,
                'postal_code' => $validated['postal_code'] ?? null,
            ]);

            $basePrice = ServiceVehiclePrice::where('service_id', $validated['service_id'])
                ->where('vehicle_type_id', $validated['vehicle_type_id'])
                ->value('price');

            if ($basePrice === null) {
                return redirect()->back()
                    ->withErrors(['vehicle_type_id' => 'Price not defined for this vehicle type and service.'])
                    ->withInput();
            }

            $extrasPrice = 0;
            $selectedExtraServices = null;
            if (!empty($validated['extras'])) {
                $selectedExtraServices = ExtraService::whereIn('id', $validated['extras'])->get();
                foreach ($selectedExtraServices as $extra) {
                    $extrasPrice += $extra->price;
                }
            }
            $montoFinal = $basePrice + $extrasPrice;

            // --- MANEJO DE ZONA HORARIA AL GUARDAR ---
            // Interpretar la fecha y hora seleccionadas como si fueran de Seattle
            $scheduledAtSeattle = Carbon::createFromFormat(
                'Y-m-d H:i',
                $validated['date'] . ' ' . $validated['time'],
                $targetTimezone  // Especifica que la entrada es hora de Seattle
            );

            // Convertir a UTC para almacenar en la base de datos
            $scheduledAtUtc = $scheduledAtSeattle->setTimezone('UTC');
            // -----------------------------------------

            $appointment = Appointment::create([
                'client_id'       => $client->id,
                'address_id'      => $clientAddress->id,
                'service_id'      => $validated['service_id'],
                'vehicle_type_id' => $validated['vehicle_type_id'],
                'scheduled_at'    => $scheduledAtUtc, // Guardar en UTC
                'monto_final'     => $montoFinal,
                'notas'           => $validated['notes'] ?? null,
                'status'          => 'Pending',
            ]);

            if ($selectedExtraServices) {
                foreach ($selectedExtraServices as $extra) {
                    AppointmentExtraService::create([
                        'appointment_id'    => $appointment->id,
                        'extra_service_id'  => $extra->id,
                        'quantity'          => 1,
                        'unit_price'        => $extra->price,
                    ]);
                }
            }
            $service = Service::find($validated['service_id']); // Para la redirección
            return redirect()
                ->route('services.book', ['service' => $service->id]) // Ajusta la ruta de redirección si es necesario
                ->with('success', 'Your appointment has been successfully booked!');
        });
    }

    public function getUnavailableTimesForDate(Request $request)
    {
        $request->validate(['date' => 'required|date_format:Y-m-d']);

        $dateString = $request->date; // ej: "2025-05-31"
        $targetTimezone = 'America/Los_Angeles'; // Zona horaria de Seattle

        // Definir el inicio y fin del día solicitado EN HORA DE SEATTLE
        try {
            $startOfDayInSeattle = Carbon::createFromFormat('Y-m-d', $dateString, $targetTimezone)->startOfDay();
            $endOfDayInSeattle = Carbon::createFromFormat('Y-m-d', $dateString, $targetTimezone)->endOfDay();
        } catch (\Exception $e) {
            // Manejar fecha inválida si Carbon::createFromFormat falla
            return response()->json([], 400); // Bad request
        }


        // Convertir estos límites de Seattle a UTC para consultar la base de datos
        // (asumiendo que 'scheduled_at' en la BD está en UTC)
        $startOfDayUtc = $startOfDayInSeattle->clone()->setTimezone('UTC');
        $endOfDayUtc = $endOfDayInSeattle->clone()->setTimezone('UTC');

        // Define los estados que indican que una cita está activa y, por lo tanto, el horario no está disponible.
        // Asegúrate que estos nombres coincidan con los que usas en tu sistema.
        $activeBookingStatuses = ['Pending', 'Accepted', 'Rejected', 'Completed'];

        $bookedAppointments = Appointment::whereBetween('scheduled_at', [$startOfDayUtc, $endOfDayUtc])
            ->whereIn('status', $activeBookingStatuses)
            ->get(['scheduled_at']); // Obtener solo la columna scheduled_at

        $unavailableTimes = $bookedAppointments->map(function ($appointment) use ($targetTimezone) {
            // $appointment->scheduled_at es un objeto Carbon (o una cadena que Carbon puede parsear) en UTC desde la BD
            // Convertirlo a la hora de Seattle y formatear
            return Carbon::parse($appointment->scheduled_at)->setTimezone($targetTimezone)->format('H:i');
        })
        ->unique()
        ->values()
        ->toArray();

        return response()->json($unavailableTimes);
    }
}