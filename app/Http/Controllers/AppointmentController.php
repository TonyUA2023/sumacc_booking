<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\ServiceVehiclePrice;
use App\Models\ExtraService;
use App\Models\AppointmentExtraService;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Create a new appointment.
     * Expects in the request:
     * - client: { first_name, last_name, email, phone }
     * - address_id (optional) or address as new: { street, city, state, postal_code }
     * - scheduled_at (ISO 8601 with timezone, e.g. '2025-06-15T10:30:00-07:00')
     * - service_id
     * - vehicle_type_id
     * - extras: array of { extra_service_id, quantity } (optional)
     * - notes (optional)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client.first_name'        => 'required|string|max:100',
            'client.last_name'         => 'required|string|max:100',
            'client.email'             => 'required|email|max:150',
            'client.phone'             => 'required|string|max:30',

            // Either address_id OR address.* must be present
            'address_id'               => 'nullable|exists:client_addresses,id',
            'address.street'           => 'required_without:address_id|string|max:200',
            'address.city'             => 'required_without:address_id|string|max:100',
            'address.state'            => 'required_without:address_id|string|max:100',
            'address.postal_code'      => 'required_without:address_id|string|max:20',

            'scheduled_at'             => 'required|date_format:Y-m-d\TH:i:sP',
            'service_id'               => 'required|exists:services,id',
            'vehicle_type_id'          => 'required|exists:vehicle_types,id',

            'extras'                   => 'sometimes|array',
            'extras.*.extra_service_id'=> 'required_with:extras|exists:extra_services,id',
            'extras.*.quantity'        => 'required_with:extras|integer|min:1',

            'notes'                    => 'nullable|string',
        ]);

        // 1) Create or update client
        $clientData = $data['client'];
        $client = Client::where('email', $clientData['email'])->first();
        if ($client) {
            $client->update([
                'first_name' => $clientData['first_name'],
                'last_name'  => $clientData['last_name'],
                'phone'      => $clientData['phone'],
            ]);
        } else {
            $client = Client::create($clientData);
        }

        // 2) Get or create address
        if (!empty($data['address_id'])) {
            $address = ClientAddress::findOrFail($data['address_id']);
            if ($address->client_id !== $client->id) {
                return response()->json([
                    'message' => 'The selected address does not belong to this client.'
                ], 422);
            }
        } else {
            $addrData = $data['address'];
            $address = ClientAddress::create([
                'client_id'   => $client->id,
                'street'      => $addrData['street'],
                'city'        => $addrData['city'],
                'state'       => $addrData['state'],
                'postal_code' => $addrData['postal_code'],
            ]);
        }

        // 3) Check for appointment collision at the same datetime
        $scheduledAt = Carbon::parse($data['scheduled_at'])->toDateTimeString();
        $exists = Appointment::where('scheduled_at', $scheduledAt)->exists();
        if ($exists) {
            return response()->json([
                'message' => 'Another appointment is already scheduled at that time. Please choose a different slot.'
            ], 409);
        }

        // 4) Get base price for service + vehicle type
        $svp = ServiceVehiclePrice::where('service_id', $data['service_id'])
                                 ->where('vehicle_type_id', $data['vehicle_type_id'])
                                 ->first();
        if (!$svp) {
            return response()->json([
                'message' => 'No price found for the chosen service and vehicle type.'
            ], 422);
        }
        $basePrice = $svp->price;

        // 5) Compute extras subtotal (if any)
        $extrasSubtotal = 0;
        if (!empty($data['extras'])) {
            foreach ($data['extras'] as $extraInput) {
                $extraModel = ExtraService::find($extraInput['extra_service_id']);
                if (!$extraModel) {
                    return response()->json([
                        'message' => 'Invalid extra service ID: ' . $extraInput['extra_service_id']
                    ], 422);
                }
                $extrasSubtotal += ($extraModel->price * $extraInput['quantity']);
            }
        }

        // 6) Compute total amount
        $totalAmount = $basePrice + $extrasSubtotal;

        // 7) Create the appointment inside a transaction
        DB::beginTransaction();
        try {
            $appointment = Appointment::create([
                'client_id'           => $client->id,
                'address_id'          => $address->id,
                'scheduled_at'        => $scheduledAt,
                'service_id'          => $data['service_id'],
                'vehicle_type_id'     => $data['vehicle_type_id'],
                'monto_final'         => $totalAmount,
                'notas'               => $data['notes'] ?? null,
                'status'              => 'Pendiente',
                'updated_by_admin_id' => null,
            ]);

            if (!empty($data['extras'])) {
                foreach ($data['extras'] as $extraInput) {
                    $extraModel = ExtraService::find($extraInput['extra_service_id']);

                    AppointmentExtraService::create([
                        'appointment_id'   => $appointment->id,
                        'extra_service_id' => $extraModel->id,
                        'quantity'         => $extraInput['quantity'],
                        'unit_price'       => $extraModel->price,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error creating appointment: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message'     => 'Appointment created successfully.',
            'appointment' => $appointment->load([
                'client', 'address', 'service', 'vehicleType', 'extraServices'
            ]),
        ], 201);
    }

    /**
     * Show the details of one appointment by its ID.
     */
    public function show($id)
    {
        $appointment = Appointment::with([
            'client',
            'address',
            'service.category',
            'vehicleType',
            'extraServices.extraService',
            'updatedByAdmin'
        ])->find($id);

        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found.'
            ], 404);
        }

        return response()->json([
            'appointment' => $appointment
        ], 200);
    }
}