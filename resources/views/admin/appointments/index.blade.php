@extends('admin.layout')

@section('title', 'Manage Appointments - SUMACC Admin')
@section('page-title', 'Appointments Management')

@section('content')
    <style>
        /* ===================== *
           ======= STYLES ====== *
           ===================== */

        /* Contenedor general */
        #fullCalendarContainer {
            max-width: 100%;
            margin: 0 auto 2rem;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Toolbar de FullCalendar */
        .fc .fc-toolbar {
            background-color: #1e40af; /* azul-800 */
            color: #f3f4f6;            /* gris-100 */
            padding: 0.75rem;
        }
        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #f3f4f6;
        }
        .fc .fc-button {
            background-color: #2563eb; /* azul-600 */
            color: #ffffff;
            border: none;
            border-radius: 0.375rem;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .fc .fc-button:disabled {
            background-color: #93c5fd; /* azul-300 */
            color: #ffffff;
        }
        .fc .fc-button:hover:not(:disabled) {
            background-color: #1e40af; /* azul-800 */
        }
        .fc .fc-button-active {
            background-color: #1e3a8a; /* azul-900 */
        }
        .fc .fc-button-group > .fc-button:not(:last-child) {
            margin-right: 0.5rem;
        }

        /* Día actual */
        .fc .fc-day-today {
            background-color: #bfdbfe; /* azul-200 */
        }

        /* Eventos diarios */
        .fc .fc-daygrid-event {
            background-color: #3b82f6; /* azul-500 */
            border: none;
            border-radius: 0.375rem;
            color: #ffffff;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        .fc .fc-daygrid-event:hover {
            transform: translateY(-2px);
            transition: transform 0.1s ease-in-out;
        }

        /* Cabeceras mensuales */
        .fc .fc-scrollgrid-section-header thead th {
            background-color: #1e40af; /* azul-800 */
            color: #f3f4f6;            /* gris-100 */
            font-weight: 700;
            font-size: 0.875rem;
            padding: 0.75rem 0.5rem;
        }

        /* Botón Today */
        .fc .fc-button.fc-button-primary {
            background-color: #10b981; /* verde-500 */
        }
        .fc .fc-button.fc-button-primary:hover {
            background-color: #047857; /* verde-700 */
        }

        /* Responsive */
        @media (max-width: 640px) {
            .fc .fc-toolbar-title {
                font-size: 1.25rem;
            }
            .fc .fc-button {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }
        }

        /* Tabla de citas */
        .appointments-table-container { overflow-x: auto; }
    </style>


    <div x-data="appointmentsPageData()" x-init="initPage()">
        <!-- ========================== *
             == CALENDARIO FULLCALENDAR ==
             ========================== -->
        <div id="fullCalendarContainer">
            <div id="calendar"></div>
        </div>

        <!-- ======================= *
             == TABLA DE CITAS CRUD ==
             ======================= -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-700">All Appointments</h3>
                <!-- Botón para abrir modal “Create” -->
                <button @click="showCreateModal = true"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600
                               border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none
                               focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"
                         stroke="currentColor">
                        <path fill-rule="evenodd"
                              d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                              clip-rule="evenodd" />
                    </svg>
                    Create New
                </button>
            </div>

            <div class="appointments-table-container">
                @if($appointments->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Client</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Service / Vehicle</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Scheduled At</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($appointments as $appointment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">#{{ $appointment->id }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($appointment->client)
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $appointment->client->first_name }} {{ $appointment->client->last_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $appointment->client->email }}</div>
                                    @else
                                        <div class="text-sm text-gray-500">N/A</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appointment->service->name ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $appointment->vehicleType->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{-- Convertir de UTC a hora local America/Los_Angeles --}}
                                    <div class="text-sm text-gray-900">
                                        {{ $appointment->scheduled_at
                                            ->setTimezone('America/Los_Angeles')
                                            ->format('M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $appointment->scheduled_at
                                            ->setTimezone('America/Los_Angeles')
                                            ->format('h:i A') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">${{ number_format($appointment->monto_final, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = match(strtolower($appointment->status)) {
                                            'pending'  => 'bg-yellow-100 text-yellow-800',
                                            'accepted' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'completed'=> 'bg-blue-100 text-blue-800',
                                            default    => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 text-xs font-semibold {{ $statusClass }} rounded-full">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <!-- Botón View -->
                                    <button @click="viewAppointment({{ Js::from($appointment) }})"
                                            class="text-indigo-600 hover:text-indigo-800 hover:underline focus:outline-none">
                                        View
                                    </button>
                                    <!-- Botón Edit -->
                                    <button @click="editAppointment({{ Js::from($appointment) }})"
                                            class="ml-4 text-blue-600 hover:text-blue-800 hover:underline focus:outline-none">
                                        Edit
                                    </button>
                                    <!-- Botón Delete -->
                                    <button @click="appointmentIdToDelete = {{ $appointment->id }};
                                                   appointmentClientNameForDelete = '{{ $appointment->client
                                                       ? addslashes($appointment->client->first_name . ' ' . $appointment->client->last_name)
                                                       : 'N/A' }}';
                                                   showDeleteModal = true"
                                            class="ml-4 text-red-600 hover:text-red-800 hover:underline focus:outline-none">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-4 border-t">
                        {{ $appointments->links() }}
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No appointments found</h3>
                        <p class="mt-1 text-sm text-gray-500">There are currently no appointments to display.</p>
                    </div>
                @endif
            </div>
        </div>


        <!-- ==================================== *
             == MODAL: CREATE NEW APPOINTMENT ==
             ==================================== -->
        <div x-show="showCreateModal"
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title-create" role="dialog" aria-modal="true" x-cloak>
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo semitransparente -->
                <div x-show="showCreateModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75" aria-hidden="true">
                </div>
                <!-- Filler para centrar verticalmente -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <!-- Cuadro modal -->
                <div x-show="showCreateModal"
                     @click.outside="showCreateModal = false"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block w-full max-w-3xl p-6 my-8 overflow-hidden text-left align-bottom
                            transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-create">
                            Create New Appointment
                        </h3>
                        <button @click="showCreateModal = false" type="button"
                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.appointments.store') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <input type="hidden" name="_form_type" value="create">

                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="create_client_id" class="block text-sm font-medium text-gray-700">
                                    Client
                                </label>
                                <select id="create_client_id" name="client_id" required
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                               rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select a client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->first_name }} {{ $client->last_name }} ({{ $client->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label for="create_service_id" class="block text-sm font-medium text-gray-700">
                                    Service
                                </label>
                                <select id="create_service_id" name="service_id" required
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                               rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select a service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}"
                                            {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label for="create_vehicle_type_id" class="block text-sm font-medium text-gray-700">
                                    Vehicle Type
                                </label>
                                <select id="create_vehicle_type_id" name="vehicle_type_id" required
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                               rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select a vehicle type</option>
                                    @foreach($vehicleTypes as $vehicleType)
                                        <option value="{{ $vehicleType->id }}"
                                            {{ old('vehicle_type_id') == $vehicleType->id ? 'selected' : '' }}>
                                            {{ $vehicleType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_type_id')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label for="create_status" class="block text-sm font-medium text-gray-700">
                                    Status
                                </label>
                                <select id="create_status" name="status" required
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                               rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @foreach($statuses as $statusValue)
                                        <option value="{{ $statusValue }}"
                                            {{ old('status', 'Pending') == $statusValue ? 'selected' : '' }}>
                                            {{ ucfirst($statusValue) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label for="create_scheduled_at_date" class="block text-sm font-medium text-gray-700">
                                    Scheduled Date
                                </label>
                                <input type="date" name="scheduled_at_date" id="create_scheduled_at_date"
                                       value="{{ old('scheduled_at_date') }}" required
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                              rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('scheduled_at_date')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-3">
                                <label for="create_scheduled_at_time" class="block text-sm font-medium text-gray-700">
                                    Scheduled Time
                                </label>
                                <input type="time" name="scheduled_at_time" id="create_scheduled_at_time"
                                       value="{{ old('scheduled_at_time') }}" required
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                              rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('scheduled_at_time')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Dirección del servicio -->
                            <h4 class="sm:col-span-6 text-sm font-medium text-gray-700 mt-2">Service Address</h4>
                            <div class="sm:col-span-6">
                                <label for="create_address_street" class="block text-sm font-medium text-gray-700">
                                    Street Address
                                </label>
                                <input type="text" name="address_street" id="create_address_street"
                                       value="{{ old('address_street') }}" required
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                              rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('address_street')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="create_address_city" class="block text-sm font-medium text-gray-700">
                                    City
                                </label>
                                <input type="text" name="address_city" id="create_address_city"
                                       value="{{ old('address_city') }}" required
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                              rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('address_city')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="create_address_state" class="block text-sm font-medium text-gray-700">
                                    State/Province
                                </label>
                                <input type="text" name="address_state" id="create_address_state"
                                       value="{{ old('address_state') }}"
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                              rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="create_address_postal_code" class="block text-sm font-medium text-gray-700">
                                    ZIP/Postal Code
                                </label>
                                <input type="text" name="address_postal_code" id="create_address_postal_code"
                                       value="{{ old('address_postal_code') }}"
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                              rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            @if($extraServices->count() > 0)
                                <div class="sm:col-span-6 mt-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Extra Services
                                    </label>
                                    <div class="p-3 border border-gray-200 rounded-md max-h-40 overflow-y-auto">
                                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
                                            @foreach($extraServices as $extra)
                                                <label class="flex items-center space-x-2">
                                                    <input type="checkbox" name="extras[]" value="{{ $extra->id }}"
                                                        {{ is_array(old('extras')) && in_array($extra->id, old('extras')) ? 'checked' : '' }}
                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                    <span class="text-sm text-gray-700">
                                                        {{ $extra->name }} (+${{ number_format($extra->price, 2) }})
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    @error('extras.*')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            <div class="sm:col-span-3">
                                <label for="create_monto_final" class="block text-sm font-medium text-gray-700">
                                    Final Amount ($)
                                </label>
                                <input type="number" name="monto_final" id="create_monto_final"
                                       value="{{ old('monto_final') }}" step="0.01" min="0" required
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                              rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="e.g., 150.00">
                                @error('monto_final')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-6">
                                <label for="create_notas" class="block text-sm font-medium text-gray-700">
                                    Notes
                                </label>
                                <textarea id="create_notas" name="notas" rows="3"
                                          class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('notas') }}</textarea>
                                @error('notas')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 mt-8 border-t border-gray-200">
                            <div class="flex justify-end space-x-3">
                                <button @click="showCreateModal = false" type="button"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300
                                               rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white
                                               bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700
                                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Create Appointment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- ============================= *
             == MODAL: EDIT APPOINTMENT ==
             ============================= -->
        <div x-show="showEditModal"
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title-edit" role="dialog" aria-modal="true" x-cloak>
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Fondo semitransparente -->
                <div x-show="showEditModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75" aria-hidden="true">
                </div>
                <!-- Filler -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <!-- Contenido modal -->
                <template x-if="appointmentToEdit">
                    <div x-show="showEditModal"
                         @click.outside="showEditModal = false; appointmentToEdit = null"
                         x-transition:enter="transition ease-out duration-300 transform"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="transition ease-in duration-200 transform"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="inline-block w-full max-w-3xl p-6 my-8 overflow-hidden text-left align-bottom
                                transition-all transform bg-white rounded-lg shadow-xl sm:align-middle">
                        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-edit">
                                Edit Appointment #<span x-text="appointmentToEdit.id"></span>
                            </h3>
                            <button @click="showEditModal = false; appointmentToEdit = null" type="button"
                                    class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form :action="`{{ url('admin/appointments') }}/${appointmentToEdit.id}`"
                              method="POST" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="_form_type" value="edit">
                            <input type="hidden" name="appointment_id_for_edit_error" :value="appointmentToEdit.id">

                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="edit_client_id" class="block text-sm font-medium text-gray-700">
                                        Client
                                    </label>
                                    <select id="edit_client_id" name="client_id" required
                                            x-model="appointmentToEdit.client_id"
                                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                   rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select a client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">
                                                {{ $client->first_name }} {{ $client->last_name }} ({{ $client->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id', 'editValidation')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="edit_service_id" class="block text-sm font-medium text-gray-700">
                                        Service
                                    </label>
                                    <select id="edit_service_id" name="service_id" required
                                            x-model="appointmentToEdit.service_id"
                                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                   rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select a service</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_id', 'editValidation')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="edit_vehicle_type_id" class="block text-sm font-medium text-gray-700">
                                        Vehicle Type
                                    </label>
                                    <select id="edit_vehicle_type_id" name="vehicle_type_id" required
                                            x-model="appointmentToEdit.vehicle_type_id"
                                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                   rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select a vehicle type</option>
                                        @foreach($vehicleTypes as $vehicleType)
                                            <option value="{{ $vehicleType->id }}">{{ $vehicleType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_type_id', 'editValidation')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="edit_status" class="block text-sm font-medium text-gray-700">
                                        Status
                                    </label>
                                    <select id="edit_status" name="status" required
                                            x-model="appointmentToEdit.status"
                                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                   rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        @foreach($statuses as $statusValue)
                                            <option value="{{ $statusValue }}">{{ ucfirst($statusValue) }}</option>
                                        @endforeach
                                    </select>
                                    @error('status', 'editValidation')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="edit_scheduled_at_date" class="block text-sm font-medium text-gray-700">
                                        Scheduled Date
                                    </label>
                                    <input type="date" name="scheduled_at_date" id="edit_scheduled_at_date"
                                           :value="appointmentToEdit.scheduled_at_date"
                                           required
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                  rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('scheduled_at_date', 'editValidation')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="edit_scheduled_at_time" class="block text-sm font-medium text-gray-700">
                                        Scheduled Time
                                    </label>
                                    <input type="time" name="scheduled_at_time" id="edit_scheduled_at_time"
                                           :value="appointmentToEdit.scheduled_at_time"
                                           required
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                  rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('scheduled_at_time', 'editValidation')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Dirección del servicio -->
                                <h4 class="sm:col-span-6 text-sm font-medium text-gray-700 mt-2">Service Address</h4>
                                <div class="sm:col-span-6">
                                    <label for="edit_address_street" class="block text-sm font-medium text-gray-700">
                                        Street Address
                                    </label>
                                    <input type="text" name="address_street" id="edit_address_street"
                                           :value="appointmentToEdit.address ? appointmentToEdit.address.street : ''"
                                           required
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                  rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('address_street', 'editValidation')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="edit_address_city" class="block text-sm font-medium text-gray-700">
                                        City
                                    </label>
                                    <input type="text" name="address_city" id="edit_address_city"
                                           :value="appointmentToEdit.address ? appointmentToEdit.address.city : ''"
                                           required
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                  rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('address_city', 'editValidation')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="edit_address_state" class="block text-sm font-medium text-gray-700">
                                        State/Province
                                    </label>
                                    <input type="text" name="address_state" id="edit_address_state"
                                           :value="appointmentToEdit.address ? appointmentToEdit.address.state : ''"
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                  rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="edit_address_postal_code" class="block text-sm font-medium text-gray-700">
                                        ZIP/Postal Code
                                    </label>
                                    <input type="text" name="address_postal_code" id="edit_address_postal_code"
                                           :value="appointmentToEdit.address ? appointmentToEdit.address.postal_code : ''"
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                  rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                @if($extraServices->count() > 0)
                                    <div class="sm:col-span-6 mt-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Extra Services
                                        </label>
                                        <div class="p-3 border border-gray-200 rounded-md max-h-40 overflow-y-auto">
                                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
                                                @foreach($extraServices as $extra)
                                                    <label class="flex items-center space-x-2">
                                                        <input type="checkbox" name="extras[]"
                                                               value="{{ $extra->id }}"
                                                               :checked="appointmentToEdit.extrasArray &&
                                                                         appointmentToEdit.extrasArray.includes('{{ (string)$extra->id }}')"
                                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                        <span class="text-sm text-gray-700">
                                                            {{ $extra->name }} (+${{ number_format($extra->price, 2) }})
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @error('extras.*', 'editValidation')
                                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif

                                <div class="sm:col-span-3">
                                    <label for="edit_monto_final" class="block text-sm font-medium text-gray-700">
                                        Final Amount ($)
                                    </label>
                                    <input type="number" name="monto_final" id="edit_monto_final"
                                           :value="appointmentToEdit.monto_final"
                                           step="0.01" min="0" required
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                  rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="e.g., 150.00">
                                    @error('monto_final', 'editValidation')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="edit_notas" class="block text-sm font-medium text-gray-700">
                                        Notes
                                    </label>
                                    <textarea id="edit_notas" name="notas" rows="3"
                                              class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300
                                                     rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                              x-text="appointmentToEdit.notas ? appointmentToEdit.notas : ''"></textarea>
                                    @error('notas', 'editValidation')
                                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="pt-6 mt-8 border-t border-gray-200">
                                <div class="flex justify-end space-x-3">
                                    <button @click="showEditModal = false; appointmentToEdit = null" type="button"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300
                                                   rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md
                                                   hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </template>
            </div>
        </div>

        <!-- ============================ *
  == MODAL: VIEW APPOINTMENT (COMPLETELY REVISED) ==
  ============================ -->
<div
  x-show="showViewModal"
  class="fixed inset-0 z-50 overflow-y-auto"
  aria-labelledby="modal-title-view"
  role="dialog"
  aria-modal="true"
  x-cloak
>
  <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
    <!-- Background overlay -->
    <div
      x-show="showViewModal"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0"
      class="fixed inset-0 bg-gray-500 bg-opacity-75"
      aria-hidden="true"
    ></div>

    <!-- Filler to center the modal contents -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">
      &#8203;
    </span>

    <!-- Modal panel -->
    <div
      x-show="showViewModal"
      @click.outside="showViewModal = false; appointmentToView = null"
      x-transition:enter="transition ease-out duration-300 transform"
      x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
      x-transition:leave="transition ease-in duration-200 transform"
      x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
      x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-lg shadow-xl sm:align-middle"
    >
      <!-- Modal header -->
      <div class="flex items-center justify-between pb-4 border-b border-gray-200">
        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-view">
          Appointment #
          <span x-text="appointmentToView ? appointmentToView.id : ''"></span>
        </h3>
        <button
          @click="showViewModal = false; appointmentToView = null"
          type="button"
          class="text-gray-400 hover:text-gray-500 focus:outline-none"
        >
          <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>

      <!-- Modal body (only rendered if appointmentToView is set) -->
      <template x-if="appointmentToView">
        <div class="mt-4 space-y-6 text-gray-700 text-sm">
          <!-- CLIENT SECTION -->
          <div class="space-y-1">
            <h4 class="text-md font-semibold text-gray-900">Client Information</h4>
            <div>
              <strong class="font-medium">Name:</strong>
              <span
                x-text="
                  appointmentToView.client
                    ? appointmentToView.client.first_name + ' ' + appointmentToView.client.last_name
                    : 'N/A'
                "
              ></span>
            </div>
            <div x-show="appointmentToView.client && appointmentToView.client.email">
              <strong class="font-medium">Email:</strong>
              <span x-text="appointmentToView.client.email"></span>
            </div>
            <div x-show="appointmentToView.client && appointmentToView.client.phone">
              <strong class="font-medium">Phone:</strong>
              <span x-text="appointmentToView.client.phone"></span>
            </div>
          </div>

          <!-- SERVICE & CATEGORY SECTION -->
          <div class="space-y-1">
            <h4 class="text-md font-semibold text-gray-900">Service Details</h4>
            <div>
              <strong class="font-medium">Service:</strong>
              <span
                x-text="
                  appointmentToView.service
                    ? appointmentToView.service.name
                    : 'N/A'
                "
              ></span>
              <span
                x-show="appointmentToView.service && appointmentToView.service.category"
                class="ml-2 text-gray-500 italic"
                >
                (<span
                  x-text="appointmentToView.service.category.name"
                ></span>)
              </span>
            </div>
          </div>

<!-- VEHICLE TYPE SECTION (corregido a snake_case) -->
<div class="space-y-1">
  <h4 class="text-md font-semibold text-gray-900">Vehicle</h4>
  <div>
    <strong class="font-medium">Type:</strong>
    <span
      x-text="
        appointmentToView.vehicle_type
          ? appointmentToView.vehicle_type.name
          : 'N/A'
      "
    ></span>
  </div>
</div>

          <!-- SCHEDULED DATETIME -->
          <div class="space-y-1">
            <h4 class="text-md font-semibold text-gray-900">Scheduled Date & Time</h4>
            <div>
              <span x-text="appointmentToView.scheduled_local"></span>
              <span class="ml-2 text-gray-500">(Local: America/Los_Angeles)</span>
            </div>
          </div>

          <!-- AMOUNT & STATUS -->
          <div class="space-y-1">
            <h4 class="text-md font-semibold text-gray-900">Payment & Status</h4>
            <div class="flex items-center space-x-2">
              <strong class="font-medium">Amount:</strong>
              <span>
                $<span
                  x-text="
                    appointmentToView.monto_final
                      ? parseFloat(appointmentToView.monto_final).toFixed(2)
                      : '0.00'
                  "
                ></span>
              </span>
            </div>
            <div class="flex items-center space-x-2">
              <strong class="font-medium">Current Status:</strong>
              <span
                :class="{
                  'inline-flex px-2.5 py-0.5 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full':
                    appointmentToView.status.toLowerCase() === 'pending',
                  'inline-flex px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-800 rounded-full':
                    ['accepted','scheduled'].includes(appointmentToView.status.toLowerCase()),
                  'inline-flex px-2.5 py-0.5 text-xs font-semibold bg-red-100 text-red-800 rounded-full':
                    appointmentToView.status.toLowerCase() === 'rejected',
                  'inline-flex px-2.5 py-0.5 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full':
                    appointmentToView.status.toLowerCase() === 'completed',
                  'inline-flex px-2.5 py-0.5 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full':
                    !['pending','accepted','scheduled','rejected','completed'].includes(appointmentToView.status.toLowerCase())
                }"
                x-text="appointmentToView.status"
              ></span>
            </div>
          </div>

          <!-- ADDRESS SECTION -->
          <div class="space-y-1" x-show="appointmentToView.address">
            <h4 class="text-md font-semibold text-gray-900">Address</h4>
            <div>
              <span
                x-text="
                  appointmentToView.address
                    ? `${appointmentToView.address.street}, ${appointmentToView.address.city}`
                        + (appointmentToView.address.state ? ', ' + appointmentToView.address.state : '')
                        + (appointmentToView.address.postal_code ? ' ' + appointmentToView.address.postal_code : '')
                    : 'N/A'
                "
              ></span>
            </div>
          </div>

          <!-- NOTES SECTION -->
          <div class="space-y-1" x-show="appointmentToView.notas">
            <h4 class="text-md font-semibold text-gray-900">Notes</h4>
            <pre class="whitespace-pre-wrap text-gray-600" x-text="appointmentToView.notas"></pre>
          </div>

          <!-- EXTRA SERVICES SECTION -->
<div
  class="space-y-1"
  x-show="appointmentToView.extra_services && appointmentToView.extra_services.length > 0"
>
  <h4 class="text-md font-semibold text-gray-900">Extra Services</h4>
  <ul class="pl-5 list-disc space-y-1">
    <template
      x-for="extra_item in appointmentToView.extra_services"
      :key="extra_item.id"
    >
      <li class="flex justify-between">
        <span>
          <span
            x-text="
              extra_item.extra_service
                ? extra_item.extra_service.name
                : 'Unknown Extra'
            "
          ></span>
        </span>
        <span class="text-gray-500 text-xs">
          Qty: <span x-text="extra_item.quantity"></span>,
          Unit Price: $<span
            x-text="
              extra_item.unit_price
                ? parseFloat(extra_item.unit_price).toFixed(2)
                : '0.00'
            "
          ></span>
        </span>
      </li>
    </template>
  </ul>
</div>

          <!-- STATUS HISTORY SECTION -->
          <div
            class="space-y-1"
            x-show="
              appointmentToView.statusHistories
              && appointmentToView.statusHistories.length > 0
            "
          >
            <h4 class="text-md font-semibold text-gray-900">Status History</h4>
            <ul class="pl-5 list-decimal space-y-1">
              <template
                x-for="history in appointmentToView.statusHistories"
                :key="history.id"
              >
                <li class="text-gray-600 text-xs">
                  <span>
                    <strong>From:</strong>
                    <span
                      x-text="history.old_status"
                    ></span>
                    <strong>→ To:</strong>
                    <span
                      x-text="history.new_status"
                    ></span>
                  </span>
                  <span class="ml-2">
                    <em>By:</em>
                    <span
                      x-text="
                        history.changedByAdmin
                          ? history.changedByAdmin.first_name + ' ' + history.changedByAdmin.last_name
                          : 'Unknown'
                      "
                    ></span>
                  </span>
                  <span class="ml-2 text-gray-400 italic">
                    (
                    <span
                      x-text="
                        history.changed_at
                          ? new Date(history.changed_at).toLocaleString('en-US', {
                              timeZone: 'America/Los_Angeles',
                              year: 'numeric',
                              month: '2-digit',
                              day: '2-digit',
                              hour: '2-digit',
                              minute: '2-digit',
                            })
                          : ''
                      "
                    ></span>
                    )
                  </span>
                </li>
              </template>
            </ul>
          </div>

          <!-- CHANGE STATUS FORM -->
          <div class="mt-6 border-t border-gray-200 pt-4">
            <h4 class="text-md font-semibold text-gray-900 pb-2">Change Status</h4>
            <form
              :action="
                `{{ route('admin.appointments.updateStatus', ['appointment' => ':id']) }}`
                  .replace(':id', appointmentToView.id)
              "
              method="POST"
              class="space-y-4"
            >
              @csrf
              @method('PATCH')
              <div>
                <label
                  for="view_status"
                  class="block text-sm font-medium text-gray-700"
                >
                  New Status
                </label>
                <select
                  id="view_status"
                  name="new_status"
                  x-model="appointmentToView.status"
                  class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300
                         rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >
                  @foreach($statuses as $statusValue)
                    <option value="{{ $statusValue }}">
                      {{ ucfirst($statusValue) }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="flex justify-end space-x-3">
                <button
                  type="button"
                  @click="showViewModal = false; appointmentToView = null"
                  class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300
                         rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  Close
                </button>
                <button
                  type="submit"
                  class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border-transparent
                         rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                  Save Status
                </button>
              </div>
            </form>
          </div>
        </div>
      </template>
    </div>
  </div>
</div>

                  

<!-- ==================================== *
 == MODAL: EDIT APPOINTMENT (ONLY TIME) ==
 ==================================== -->
<div
    x-show="showEditModal"
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title-edit"
    role="dialog"
    aria-modal="true"
    x-cloak
>
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Fondo semitransparente -->
        <div
            x-show="showEditModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75"
            aria-hidden="true"
        ></div>

        <!-- Filler para centrar verticalmente -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- ●●● Contenedor principal con @click.outside ●●● -->
        <template x-if="appointmentToEdit">
            <div
                x-show="showEditModal"
                @click.outside="showEditModal = false; appointmentToEdit = null"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-3xl p-0 my-8 align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:align-middle"
            >
                <!-- ●●● Dentro de este div interactivo con @click.stop ●●● -->
                <div @click.stop class="p-6 space-y-6">
                    <!-- Encabezado del modal -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-edit">
                            Edit Appointment #<span x-text="appointmentToEdit.id"></span>
                        </h3>
                        <button
                            @click="showEditModal = false; appointmentToEdit = null"
                            type="button"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none"
                        >
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Formulario de edición: SOLO HORA EDITABLE -->
                    <form
                        :action="`{{ url('admin/appointments') }}/${appointmentToEdit.id}`"
                        method="POST"
                        class="space-y-6"
                    >
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_form_type" value="edit">
                        <input type="hidden" name="appointment_id_for_edit_error" :value="appointmentToEdit.id">

                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <!-- FECHA PROGRAMADA (readonly) -->
                            <div class="sm:col-span-3">
                                <label
                                    for="edit_scheduled_at_date"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Scheduled Date
                                </label>
                                <input
                                    type="date"
                                    name="scheduled_at_date"
                                    id="edit_scheduled_at_date"
                                    :value="appointmentToEdit.scheduled_at_date"
                                    readonly
                                    class="block w-full px-3 py-2 mt-1 text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm sm:text-sm"
                                />
                            </div>

                            <!-- HORA PROGRAMADA (editable) -->
                            <div class="sm:col-span-3">
                                <label
                                    for="edit_scheduled_at_time"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Scheduled Time
                                </label>
                                <input
                                    type="time"
                                    name="scheduled_at_time"
                                    id="edit_scheduled_at_time"
                                    x-model="appointmentToEdit.scheduled_at_time"
                                    required
                                    class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                />
                                @error('scheduled_at_time', 'editValidation')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- ---------- CAMPOS OCULTOS NECESARIOS PARA VALIDACIÓN ---------- -->
                            <!-- Client ID -->
                            <input
                                type="hidden"
                                name="client_id"
                                :value="appointmentToEdit.client_id"
                            />

                            <!-- Service ID -->
                            <input
                                type="hidden"
                                name="service_id"
                                :value="appointmentToEdit.service_id"
                            />

                            <!-- Vehicle Type ID -->
                            <input
                                type="hidden"
                                name="vehicle_type_id"
                                :value="appointmentToEdit.vehicle_type_id"
                            />

                            <!-- Dirección -->
                            <input
                                type="hidden"
                                name="address_street"
                                :value="appointmentToEdit.address ? appointmentToEdit.address.street : ''"
                            />
                            <input
                                type="hidden"
                                name="address_city"
                                :value="appointmentToEdit.address ? appointmentToEdit.address.city : ''"
                            />
                            <input
                                type="hidden"
                                name="address_state"
                                :value="appointmentToEdit.address ? appointmentToEdit.address.state : ''"
                            />
                            <input
                                type="hidden"
                                name="address_postal_code"
                                :value="appointmentToEdit.address ? appointmentToEdit.address.postal_code : ''"
                            />

                            <!-- Monto Final -->
                            <input
                                type="hidden"
                                name="monto_final"
                                :value="appointmentToEdit.monto_final"
                            />

                            <!-- Status -->
                            <input
                                type="hidden"
                                name="status"
                                :value="appointmentToEdit.status"
                            />

                            <!-- Extras: un hidden por cada extra seleccionado -->
                            <template
                                x-for="id in appointmentToEdit.extrasArray"
                                :key="id"
                            >
                                <input
                                    type="hidden"
                                    name="extras[]"
                                    :value="id"
                                />
                            </template>

                            <!-- Notas -->
                            <input
                                type="hidden"
                                name="notas"
                                :value="appointmentToEdit.notas"
                            />
                        </div>

                        <!-- Botones de acción -->
                        <div class="pt-6 mt-8 border-t border-gray-200">
                            <div class="flex justify-end space-x-3">
                                <button
                                    @click="showEditModal = false; appointmentToEdit = null"
                                    type="button"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Save Time
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Fin de <div @click.stop> -->
            </div>
            <!-- Fin de <div @click.outside> -->
        </template>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js"></script>

<script>
    function appointmentsPageData() {
        return {
            showCreateModal: {{ ($errors->any() && old('_form_type') === 'create') || session('open_create_modal') ? 'true' : 'false' }},
            showEditModal:   {{ ($errors->hasBag('editValidation')) || session('open_edit_modal') ? 'true' : 'false' }},
            appointmentToEdit: @json(session('appointment_to_edit_on_error')) || ({{ old('_form_type') === 'edit' && old('appointment_id_for_edit_error') ? '{ "id": ' . Js::from(old('appointment_id_for_edit_error')) . ' }' : 'null' }}),
            showViewModal: false,
            appointmentToView: null,
            showDeleteModal: false,
            appointmentIdToDelete: null,
            appointmentClientNameForDelete: '',
            fullCalendar: null,

            initPage() {
                const oldFormType = "{{ old('_form_type') }}";
                if (this.showCreateModal || ({{ $errors->any() ? 'true' : 'false' }} && oldFormType === 'create')) {
                    this.showCreateModal = true;
                }
                if (this.showEditModal || ({{ $errors->hasBag('editValidation') ? 'true' : 'false' }} && oldFormType === 'edit')) {
                    if (this.appointmentToEdit && this.appointmentToEdit.id) {
                        this.prepareAppointmentForEdit(this.appointmentToEdit, true);
                        this.showEditModal = true;
                    }
                }
                this.initializeFullCalendar();
            },

            prepareAppointmentForEdit(appointmentData, fromError = false) {
                // Hacemos un clon profundo para no mutar el original
                let dataToProcess = JSON.parse(JSON.stringify(appointmentData));

                // --- NUEVO: usar scheduled_local en vez de parsear scheduled_at ---
                // scheduled_local viene como "YYYY-MM-DD HH:mm:ss"
                if (dataToProcess.scheduled_local) {
                    const [datePart, timePart] = dataToProcess.scheduled_local.split(' ');
                    dataToProcess.scheduled_at_date = datePart;
                    // Tomamos solo "HH:mm" de "HH:mm:ss"
                    dataToProcess.scheduled_at_time = timePart.substring(0, 5);
                } else if (dataToProcess.scheduled_at) {
                    // Fallback por si no hubiese scheduled_local (no debería usarse)
                    const scheduledDate = new Date(dataToProcess.scheduled_at);
                    dataToProcess.scheduled_at_date = scheduledDate.toISOString().substring(0, 10);
                    dataToProcess.scheduled_at_time = scheduledDate.toTimeString().substring(0, 5);
                }

                // Extraemos IDs de extras previos
                dataToProcess.extrasArray = dataToProcess.extraServices
                    ? dataToProcess.extraServices.map(es => (es.extra_service_id || es.id).toString())
                    : [];

                // Si venimos de un error de validación, sobreescribimos con los old(...) correspondientes
                if (fromError) {
                    dataToProcess.client_id = dataToProcess.client_id || "{{ old('client_id') }}";
                    dataToProcess.service_id = dataToProcess.service_id || "{{ old('service_id') }}";
                    dataToProcess.vehicle_type_id = dataToProcess.vehicle_type_id || "{{ old('vehicle_type_id') }}";
                    dataToProcess.status = dataToProcess.status || "{{ old('status') }}";
                    dataToProcess.scheduled_at_date = dataToProcess.scheduled_at_date || "{{ old('scheduled_at_date') }}";
                    dataToProcess.scheduled_at_time = dataToProcess.scheduled_at_time || "{{ old('scheduled_at_time') }}";
                    if (!dataToProcess.address) dataToProcess.address = {};
                    dataToProcess.address.street      = (dataToProcess.address && dataToProcess.address.street) || "{{ old('address_street') }}";
                    dataToProcess.address.city        = (dataToProcess.address && dataToProcess.address.city) || "{{ old('address_city') }}";
                    dataToProcess.address.state       = (dataToProcess.address && dataToProcess.address.state) || "{{ old('address_state') }}";
                    dataToProcess.address.postal_code = (dataToProcess.address && dataToProcess.address.postal_code) || "{{ old('address_postal_code') }}";
                    dataToProcess.monto_final = dataToProcess.monto_final || "{{ old('monto_final') }}";
                    dataToProcess.notas       = dataToProcess.notas       || "{{ old('notas') }}";
                    const oldExtras = @json(old('extras', []));
                    if (oldExtras && oldExtras.length > 0) {
                        dataToProcess.extrasArray = oldExtras.map(String);
                    }
                }

                return dataToProcess;
            },

            initializeFullCalendar() {
                const calendarEl = document.getElementById('calendar');
                if (!calendarEl) return;

                this.fullCalendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    themeSystem: 'standard',
                    navLinks: true,
                    weekNumbers: false,
                    dayMaxEvents: true,
                    slotMinTime: "08:00:00",
                    slotMaxTime: "22:00:00",
                    allDaySlot: false,
                    height: 650,
                    firstDay: 1, // lunes

                    events: (fetchInfo, successCallback, failureCallback) => {
                        const start = fetchInfo.startStr.substring(0, 10);
                        const end   = fetchInfo.endStr.substring(0, 10);
                        fetch(`{{ route('admin.api.calendar.events') }}?start=${start}&end=${end}`)
                            .then(response => response.ok ? response.json() : Promise.reject(response))
                            .then(data => {
                                successCallback(data.map(evt => ({
                                    id:            evt.id,
                                    title:         evt.title,
                                    start:         evt.start,
                                    end:           evt.end,
                                    backgroundColor: evt.backgroundColor,
                                    borderColor:     evt.borderColor,
                                    textColor:       evt.color,
                                    extendedProps:   evt.raw
                                })));
                            })
                            .catch(error => {
                                console.error('Error loading events:', error);
                                failureCallback(error);
                            });
                    },

                    eventClick: (info) => {
                        if (!info.event.id) return;
                        let urlTemplate = `{{ route('admin.api.appointments.details', ['appointment' => ':id']) }}`;
                        let url = urlTemplate.replace(':id', info.event.id);

                        fetch(url)
                            .then(response => response.ok ? response.json() : Promise.reject(response))
                            .then(details => {
                                    console.log('Respuesta JSON del controlador:', details);
                                    this.viewAppointment(details);
                            })
                            .catch(error => {
                                console.error('Error fetching details:', error);
                                alert('No se pudo cargar la cita: ' + (error.message || error));
                            });
                    }
                });

                this.fullCalendar.render();
            },

            editAppointment(appointmentData) {
                if (!appointmentData) return;
                this.appointmentToEdit = this.prepareAppointmentForEdit(appointmentData);
                this.showEditModal = true;
            },

            viewAppointment(appointmentData) {
                if (!appointmentData) return;
                this.appointmentToView = JSON.parse(JSON.stringify(appointmentData));
                this.showViewModal = true;
            }

            
        };        
    }

    

    document.addEventListener('alpine:init', () => {
        Alpine.data('appointmentsPageData', appointmentsPageData);
    });
</script>

@endsection