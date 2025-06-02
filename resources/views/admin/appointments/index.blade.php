@extends('admin.layout')

@section('title', 'Manage Appointments - SUMACC Admin')
@section('page-title', 'Appointments Management')

@section('content')
    {{-- Cargar Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- TOAST UI Calendar CSS y JS --}}
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js" defer></script>
    <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.min.js" defer></script>
    <script src="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.min.js" defer></script>
    <script src="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.min.js" defer></script>

    <style>
        /* ==================== Contenedor del calendario ==================== */
        #adminAppointmentsCalendarView {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            background-color: #ffffff;
            margin: 1rem 0;
        }
        /* Botones de Toast UI Calendar */
        #adminAppointmentsCalendarView .toastui-calendar-button {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: white !important;
            text-transform: capitalize !important;
            box-shadow: none !important;
            border-radius: 0.375rem !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem !important;
            line-height: 1.25rem !important;
        }
        #adminAppointmentsCalendarView .toastui-calendar-button:hover {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
        }
        #adminAppointmentsCalendarView .toastui-calendar-dropdown,
        #adminAppointmentsCalendarView .toastui-calendar-popup-section {
            z-index: 100;
        }
    </style>

    <div x-data="appointmentsPageData()" @init="initPage()">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <div class="flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
                    <h3 class="text-lg font-medium text-gray-700">All Appointments</h3>
                    <div class="flex items-center space-x-3">
                        <div class="flex rounded-md shadow-sm">
                            <button @click="switchToTableView()" type="button"
                                    :class="activeView === 'table' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium border border-gray-300 rounded-l-md focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                Table View
                            </button>
                            <button @click="switchToCalendarView()" type="button"
                                    :class="activeView === 'calendar' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium border border-gray-300 rounded-r-md focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                Calendar View
                            </button>
                        </div>
                        <button @click="showCreateModal = true" type="button"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Create New
                        </button>
                    </div>
                </div>
            </div>

            {{-- ==================== VISTA EN TABLA ==================== --}}
            <div x-show="activeView === 'table'" x-transition>
                <div class="overflow-x-auto">
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
                                    @php
                                        $appointmentDataForModal = $appointment->loadMissing([
                                            'client','service','vehicleType','address','extraServices.extraService'
                                        ]);
                                    @endphp
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">#{{ $appointment->id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($appointment->client)
                                                <div class="text-sm font-medium text-gray-900">{{ $appointment->client->first_name }} {{ $appointment->client->last_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $appointment->client->email }}</div>
                                            @else
                                                <div class="text-sm text-gray-500">N/A</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($appointment->service)
                                                <div class="text-sm text-gray-900">{{ $appointment->service->name }}</div>
                                            @else
                                                <div class="text-sm text-gray-500">N/A</div>
                                            @endif
                                            @if($appointment->vehicleType)
                                                <div class="text-sm text-gray-500">{{ $appointment->vehicleType->name }}</div>
                                            @else
                                                <div class="text-sm text-gray-500">N/A</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $appointment->scheduled_at->format('M d, Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $appointment->scheduled_at->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">${{ number_format($appointment->monto_final, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClass = '';
                                                switch (strtolower($appointment->status)) {
                                                    case 'pending':    $statusClass = 'bg-yellow-100 text-yellow-800'; break;
                                                    case 'accepted':   $statusClass = 'bg-green-100 text-green-800'; break;
                                                    case 'rejected':   $statusClass = 'bg-red-100 text-red-800'; break;
                                                    case 'completed':  $statusClass = 'bg-blue-100 text-blue-800'; break;
                                                    default:           $statusClass = 'bg-gray-100 text-gray-800';
                                                }
                                            @endphp
                                            <span class="inline-flex px-2.5 py-0.5 text-xs font-semibold {{ $statusClass }} rounded-full">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <button @click="viewAppointment({{ Js::from($appointmentDataForModal) }})"
                                                    class="text-indigo-600 hover:text-indigo-800 hover:underline focus:outline-none">
                                                View
                                            </button>
                                            <button @click="editAppointment({{ Js::from($appointmentDataForModal) }})"
                                                    class="ml-4 text-blue-600 hover:text-blue-800 hover:underline focus:outline-none">
                                                Edit
                                            </button>
                                            <button @click="
                                                appointmentIdToDelete = {{ $appointment->id }};
                                                appointmentClientNameForDelete = '{{ $appointment->client ? addslashes($appointment->client->first_name . ' ' . $appointment->client->last_name) : 'N/A' }}';
                                                showDeleteModal = true
                                            "
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
                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No appointments found</h3>
                            <p class="mt-1 text-sm text-gray-500">There are currently no appointments to display.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ==================== VISTA EN CALENDARIO ==================== --}}
            <div x-show="activeView === 'calendar'" id="adminAppointmentsCalendarView" x-transition x-cloak class="p-2 md:p-4">
                {{-- Controles manuales para Toast UI Calendar --}}
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <button @click="tuiCalendarInstance && tuiCalendarInstance.prev()"
                                class="px-3 py-1 border rounded-md">Prev</button>
                        <button @click="tuiCalendarInstance && tuiCalendarInstance.next()"
                                class="px-3 py-1 border rounded-md ml-2">Next</button>
                        <button @click="tuiCalendarInstance && tuiCalendarInstance.today()"
                                class="px-3 py-1 border rounded-md ml-2">Today</button>
                    </div>
                    <span x-text="tuiCalendarCurrentDateRange" class="text-lg font-semibold"></span>
                    <div>
                        <select @change="tuiCalendarInstance && tuiCalendarInstance.changeView($event.target.value)"
                                class="border rounded-md p-1">
                            <option value="month">Month</option>
                            <option value="week">Week</option>
                            <option value="day">Day</option>
                        </select>
                    </div>
                </div>
                <div id="tuiCalendarContainer" style="height: 700px;"></div>
            </div>
        </div>

        {{-- ==================== MODAL DE CREACIÓN ==================== --}}
        <div x-show="showCreateModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-create" role="dialog" aria-modal="true" x-cloak>
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                {{-- Fondo semitransparente --}}
                <div x-show="showCreateModal" x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true">
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showCreateModal"
                     @click.outside="showCreateModal = false"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block w-full max-w-3xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-create">Create New Appointment</h3>
                        <button @click="showCreateModal = false" type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <form action="{{ route('admin.appointments.store') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <input type="hidden" name="_form_type" value="create">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            {{-- CLIENT --}}
                            <div class="sm:col-span-3">
                                <label for="create_client_id" class="block text-sm font-medium text-gray-700">Client</label>
                                <select id="create_client_id" name="client_id" required
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select a client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->first_name }} {{ $client->last_name }} ({{ $client->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- SERVICE --}}
                            <div class="sm:col-span-3">
                                <label for="create_service_id" class="block text-sm font-medium text-gray-700">Service</label>
                                <select id="create_service_id" name="service_id" required
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select a service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('service_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- VEHICLE TYPE --}}
                            <div class="sm:col-span-3">
                                <label for="create_vehicle_type_id" class="block text-sm font-medium text-gray-700">Vehicle Type</label>
                                <select id="create_vehicle_type_id" name="vehicle_type_id" required
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select a vehicle type</option>
                                    @foreach($vehicleTypes as $vehicleType)
                                        <option value="{{ $vehicleType->id }}" {{ old('vehicle_type_id') == $vehicleType->id ? 'selected' : '' }}>
                                            {{ $vehicleType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vehicle_type_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- STATUS --}}
                            <div class="sm:col-span-3">
                                <label for="create_status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="create_status" name="status" required
                                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @foreach($statuses as $statusValue)
                                        <option value="{{ $statusValue }}" {{ old('status', 'Pending') == $statusValue ? 'selected' : '' }}>
                                            {{ ucfirst($statusValue) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- SCHEDULED DATE --}}
                            <div class="sm:col-span-3">
                                <label for="create_scheduled_at_date" class="block text-sm font-medium text-gray-700">Scheduled Date</label>
                                <input type="date" name="scheduled_at_date" id="create_scheduled_at_date"
                                       value="{{ old('scheduled_at_date') }}" required
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('scheduled_at_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- SCHEDULED TIME --}}
                            <div class="sm:col-span-3">
                                <label for="create_scheduled_at_time" class="block text-sm font-medium text-gray-700">Scheduled Time</label>
                                <input type="time" name="scheduled_at_time" id="create_scheduled_at_time"
                                       value="{{ old('scheduled_at_time') }}" required
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('scheduled_at_time') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <h4 class="sm:col-span-6 text-sm font-medium text-gray-700 mt-2">Service Address</h4>
                            {{-- ADDRESS STREET --}}
                            <div class="sm:col-span-6">
                                <label for="create_address_street" class="block text-sm font-medium text-gray-700">Street Address</label>
                                <input type="text" name="address_street" id="create_address_street"
                                       value="{{ old('address_street') }}" required
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('address_street') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- ADDRESS CITY --}}
                            <div class="sm:col-span-2">
                                <label for="create_address_city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="address_city" id="create_address_city"
                                       value="{{ old('address_city') }}" required
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('address_city') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- ADDRESS STATE --}}
                            <div class="sm:col-span-2">
                                <label for="create_address_state" class="block text-sm font-medium text-gray-700">State/Province</label>
                                <input type="text" name="address_state" id="create_address_state"
                                       value="{{ old('address_state') }}"
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                            {{-- ADDRESS POSTAL CODE --}}
                            <div class="sm:col-span-2">
                                <label for="create_address_postal_code" class="block text-sm font-medium text-gray-700">ZIP/Postal Code</label>
                                <input type="text" name="address_postal_code" id="create_address_postal_code"
                                       value="{{ old('address_postal_code') }}"
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            @if($extraServices->count() > 0)
                            {{-- EXTRA SERVICES --}}
                            <div class="sm:col-span-6 mt-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Extra Services</label>
                                <div class="p-3 border border-gray-200 rounded-md max-h-40 overflow-y-auto">
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
                                        @foreach($extraServices as $extra)
                                            <label class="flex items-center space-x-2">
                                                <input type="checkbox" name="extras[]" value="{{ $extra->id }}"
                                                       {{ is_array(old('extras')) && in_array($extra->id, old('extras')) ? 'checked' : '' }}
                                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                <span class="text-sm text-gray-700">{{ $extra->name }} (+${{ number_format($extra->price, 2) }})</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                @error('extras.*') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            @endif

                            {{-- MONTO FINAL --}}
                            <div class="sm:col-span-3">
                                <label for="create_monto_final" class="block text-sm font-medium text-gray-700">Final Amount ($)</label>
                                <input type="number" name="monto_final" id="create_monto_final"
                                       value="{{ old('monto_final') }}" step="0.01" min="0" required
                                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="e.g., 150.00">
                                @error('monto_final') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            {{-- NOTAS --}}
                            <div class="sm:col-span-6">
                                <label for="create_notas" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea id="create_notas" name="notas" rows="3"
                                          class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('notas') }}</textarea>
                                @error('notas') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="pt-6 mt-8 border-t border-gray-200">
                            <div class="flex justify-end space-x-3">
                                <button @click="showCreateModal = false" type="button"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Create Appointment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ==================== MODAL DE EDICIÓN ==================== --}}
        <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-edit" role="dialog" aria-modal="true" x-cloak>
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                {{-- Fondo semitransparente --}}
                <div x-show="showEditModal" x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <template x-if="appointmentToEdit">
                    <div x-show="showEditModal"
                         @click.outside="showEditModal = false; appointmentToEdit = null"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="inline-block w-full max-w-3xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:align-middle">
                        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-edit">Edit Appointment #<span x-text="appointmentToEdit.id"></span></h3>
                            <button @click="showEditModal = false; appointmentToEdit = null" type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <form :action="`{{ url('admin/appointments') }}/${appointmentToEdit.id}`" method="POST" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="_form_type" value="edit">
                            <input type="hidden" name="appointment_id_for_edit_error" :value="appointmentToEdit.id">

                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                {{-- CLIENT --}}
                                <div class="sm:col-span-3">
                                    <label for="edit_client_id" class="block text-sm font-medium text-gray-700">Client</label>
                                    <select id="edit_client_id" name="client_id" required x-model="appointmentToEdit.client_id"
                                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select a client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->last_name }} ({{ $client->email }})</option>
                                        @endforeach
                                    </select>
                                    @error('client_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                {{-- SERVICE --}}
                                <div class="sm:col-span-3">
                                    <label for="edit_service_id" class="block text-sm font-medium text-gray-700">Service</label>
                                    <select id="edit_service_id" name="service_id" required x-model="appointmentToEdit.service_id"
                                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select a service</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                {{-- VEHICLE TYPE --}}
                                <div class="sm:col-span-3">
                                    <label for="edit_vehicle_type_id" class="block text-sm font-medium text-gray-700">Vehicle Type</label>
                                    <select id="edit_vehicle_type_id" name="vehicle_type_id" required x-model="appointmentToEdit.vehicle_type_id"
                                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select a vehicle type</option>
                                        @foreach($vehicleTypes as $vehicleType)
                                            <option value="{{ $vehicleType->id }}">{{ $vehicleType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_type_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                {{-- STATUS --}}
                                <div class="sm:col-span-3">
                                    <label for="edit_status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select id="edit_status" name="status" required x-model="appointmentToEdit.status"
                                            class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        @foreach($statuses as $statusValue)
                                            <option value="{{ $statusValue }}">{{ ucfirst($statusValue) }}</option>
                                        @endforeach
                                    </select>
                                    @error('status') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                {{-- SCHEDULED DATE --}}
                                <div class="sm:col-span-3">
                                    <label for="edit_scheduled_at_date" class="block text-sm font-medium text-gray-700">Scheduled Date</label>
                                    <input type="date" name="scheduled_at_date" id="edit_scheduled_at_date"
                                           :value="appointmentToEdit.scheduled_at_date" required
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('scheduled_at_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                {{-- SCHEDULED TIME --}}
                                <div class="sm:col-span-3">
                                    <label for="edit_scheduled_at_time" class="block text-sm font-medium text-gray-700">Scheduled Time</label>
                                    <input type="time" name="scheduled_at_time" id="edit_scheduled_at_time"
                                           :value="appointmentToEdit.scheduled_at_time" required
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('scheduled_at_time') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <h4 class="sm:col-span-6 text-sm font-medium text-gray-700 mt-2">Service Address</h4>
                                {{-- ADDRESS STREET --}}
                                <div class="sm:col-span-6">
                                    <label for="edit_address_street" class="block text-sm font-medium text-gray-700">Street Address</label>
                                    <input type="text" name="address_street" id="edit_address_street"
                                           :value="appointmentToEdit.address ? appointmentToEdit.address.street : ''" required
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('address_street') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                {{-- ADDRESS CITY --}}
                                <div class="sm:col-span-2">
                                    <label for="edit_address_city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" name="address_city" id="edit_address_city"
                                           :value="appointmentToEdit.address ? appointmentToEdit.address.city : ''" required
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @error('address_city') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                {{-- ADDRESS STATE --}}
                                <div class="sm:col-span-2">
                                    <label for="edit_address_state" class="block text-sm font-medium text-gray-700">State/Province</label>
                                    <input type="text" name="address_state" id="edit_address_state"
                                           :value="appointmentToEdit.address ? appointmentToEdit.address.state : ''"
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                {{-- ADDRESS POSTAL CODE --}}
                                <div class="sm:col-span-2">
                                    <label for="edit_address_postal_code" class="block text-sm font-medium text-gray-700">ZIP/Postal Code</label>
                                    <input type="text" name="address_postal_code" id="edit_address_postal_code"
                                           :value="appointmentToEdit.address ? appointmentToEdit.address.postal_code : ''"
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                @if($extraServices->count() > 0)
                                {{-- EXTRA SERVICES --}}
                                <div class="sm:col-span-6 mt-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Extra Services</label>
                                    <div class="p-3 border border-gray-200 rounded-md max-h-40 overflow-y-auto">
                                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
                                            @foreach($extraServices as $extra)
                                                <label class="flex items-center space-x-2">
                                                    <input type="checkbox" name="extras[]" value="{{ $extra->id }}"
                                                           :checked="appointmentToEdit.extrasArray && appointmentToEdit.extrasArray.includes('{{ $extra->id }}')"
                                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                    <span class="text-sm text-gray-700">{{ $extra->name }} (+${{ number_format($extra->price, 2) }})</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    @error('extras.*') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                @endif

                                {{-- MONTO FINAL --}}
                                <div class="sm:col-span-3">
                                    <label for="edit_monto_final" class="block text-sm font-medium text-gray-700">Final Amount ($)</label>
                                    <input type="number" name="monto_final" id="edit_monto_final"
                                           :value="appointmentToEdit.monto_final" step="0.01" min="0" required
                                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="e.g., 150.00">
                                    @error('monto_final') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                                {{-- NOTAS --}}
                                <div class="sm:col-span-6">
                                    <label for="edit_notas" class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea id="edit_notas" name="notas" rows="3"
                                              class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                              x-text="appointmentToEdit.notas ? appointmentToEdit.notas : ''"></textarea>
                                    @error('notas') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="pt-6 mt-8 border-t border-gray-200">
                                <div class="flex justify-end space-x-3">
                                    <button @click="showEditModal = false; appointmentToEdit = null" type="button"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </template>
            </div>
        </div>

        {{-- ==================== MODAL DE VISUALIZACIÓN / ACTUALIZACIÓN DE ESTADO ==================== --}}
        <div x-show="showViewModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-view" role="dialog" aria-modal="true" x-cloak>
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                {{-- Fondo semitransparente --}}
                <div x-show="showViewModal" x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="showViewModal"
                     @click.outside="showViewModal = false; appointmentToView = null"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block w-full max-w-xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:align-middle">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-view">
                            Appointment #<span x-text="appointmentToView ? appointmentToView.id : ''"></span>
                        </h3>
                        <button @click="showViewModal = false; appointmentToView = null" type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <template x-if="appointmentToView">
                        <div class="mt-4 space-y-4">
                            {{-- CLIENT --}}
                            <div>
                                <strong class="font-medium text-gray-700">Client:</strong>
                                <span x-text="appointmentToView.client ? appointmentToView.client.first_name + ' ' + appointmentToView.client.last_name : 'N/A'"></span>
                                (<span x-text="appointmentToView.client ? appointmentToView.client.email : 'N/A'"></span>)
                            </div>
                            {{-- SERVICE --}}
                            <div>
                                <strong class="font-medium text-gray-700">Service:</strong>
                                <span x-text="appointmentToView.service ? appointmentToView.service.name : 'N/A'"></span>
                            </div>
                            {{-- VEHICLE TYPE --}}
                            <div>
                                <strong class="font-medium text-gray-700">Vehicle Type:</strong>
                                <span x-text="appointmentToView.vehicle_type ? appointmentToView.vehicle_type.name : 'N/A'"></span>
                            </div>
                            {{-- SCHEDULED --}}
                            <div>
                                <strong class="font-medium text-gray-700">Scheduled:</strong>
                                <span x-text="new Date(appointmentToView.scheduled_at).toLocaleString('en-US', { dateStyle: 'long', timeStyle: 'short' })"></span>
                            </div>
                            {{-- AMOUNT --}}
                            <div>
                                <strong class="font-medium text-gray-700">Amount:</strong>
                                $<span x-text="appointmentToView.monto_final ? parseFloat(appointmentToView.monto_final).toFixed(2) : '0.00'"></span>
                            </div>
                            {{-- STATUS --}}
                            <div>
                                <strong class="font-medium text-gray-700">Status:</strong>
                                <span :class="{
                                    'inline-flex px-2.5 py-0.5 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full': appointmentToView.status === 'Pending',
                                    'inline-flex px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-800 rounded-full': appointmentToView.status === 'Accepted',
                                    'inline-flex px-2.5 py-0.5 text-xs font-semibold bg-red-100 text-red-800 rounded-full': appointmentToView.status === 'Rejected',
                                    'inline-flex px-2.5 py-0.5 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full': appointmentToView.status === 'Completed',
                                }" x-text="appointmentToView.status">
                                </span>
                            </div>
                            {{-- ADDRESS --}}
                            <div x-show="appointmentToView.address">
                                <strong class="font-medium text-gray-700">Address:</strong>
                                <span x-text="appointmentToView.address
                                    ? `${appointmentToView.address.street}, ${appointmentToView.address.city}`
                                      + (appointmentToView.address.state ? ', '+appointmentToView.address.state : '')
                                      + (appointmentToView.address.postal_code ? ' '+appointmentToView.address.postal_code : '')
                                    : 'N/A'"></span>
                            </div>
                            {{-- NOTES --}}
                            <div x-show="appointmentToView.notas">
                                <strong class="font-medium text-gray-700">Notes:</strong>
                                <pre class="text-sm text-gray-600 whitespace-pre-wrap" x-text="appointmentToView.notas"></pre>
                            </div>
                            {{-- EXTRA SERVICES --}}
                            <div x-show="appointmentToView.extra_services && appointmentToView.extra_services.length > 0">
                                <strong class="block mt-3 mb-1 font-medium text-gray-700">Extra Services:</strong>
                                <ul class="pl-5 list-disc">
                                    <template x-for="extra_service_item in appointmentToView.extra_services" :key="extra_service_item.id">
                                        <li class="text-sm text-gray-600">
                                            <span x-text="extra_service_item.extra_service ? extra_service_item.extra_service.name : 'Unknown Extra'"></span>
                                            (Qty: <span x-text="extra_service_item.quantity"></span>,
                                            Price: $<span x-text="extra_service_item.unit_price ? parseFloat(extra_service_item.unit_price).toFixed(2) : '0.00'"></span>)
                                        </li>
                                    </template>
                                </ul>
                            </div>
                            {{-- FORMULARIO PARA CAMBIAR ESTADO --}}
                            <div class="mt-6">
                                <form :action="`{{ url('admin/appointments') }}/${appointmentToView.id}/status`" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label for="view_status" class="block text-sm font-medium text-gray-700">Change Status</label>
                                        <select id="view_status" name="new_status" x-model="appointmentToView.status"
                                                class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="Pending">Pending</option>
                                            <option value="Accepted">Accepted</option>
                                            <option value="Rejected">Rejected</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" @click="showViewModal = false; appointmentToView = null"
                                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Close
                                        </button>
                                        <button type="submit"
                                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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

        {{-- ==================== MODAL DE ELIMINACIÓN ==================== --}}
        <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-delete" role="dialog" aria-modal="true" x-cloak>
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                {{-- Fondo semitransparente --}}
                <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="showDeleteModal"
                     @click.outside="showDeleteModal = false; appointmentIdToDelete = null; appointmentClientNameForDelete = ''"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:align-middle">
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title-delete">Delete Appointment</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete appointment #
                                    <strong x-text="appointmentIdToDelete"></strong>
                                    for <strong x-text="appointmentClientNameForDelete"></strong>? This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <form :action="appointmentIdToDelete ? `{{ url('admin/appointments') }}/${appointmentIdToDelete}` : '#'" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    :disabled="!appointmentIdToDelete"
                                    class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                                Delete
                            </button>
                        </form>
                        <button @click="showDeleteModal = false; appointmentIdToDelete = null; appointmentClientNameForDelete = ''" type="button"
                                class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================== SCRIPT Alpine ==================== --}}
    <script>
        function appointmentsPageData() {
            return {
                activeView: 'table',
                showCreateModal: {{ ($errors->any() && old('_form_type') === 'create') || session('open_create_modal') ? 'true' : 'false' }},
                showEditModal:   {{ ($errors->any() && old('_form_type') === 'edit')   || session('open_edit_modal')   ? 'true' : 'false' }},
                appointmentToEdit: {{ session('appointment_to_edit_on_error')
                                    ? Js::from(session('appointment_to_edit_on_error'))
                                    : (old('_form_type') === 'edit' && old('appointment_id_for_edit_error')
                                        ? '{ "id": ' . Js::from(old('appointment_id_for_edit_error')) . ' }'
                                        : 'null') }},
                showViewModal: false,
                appointmentToView: null,
                showDeleteModal: false,
                appointmentIdToDelete: null,
                appointmentClientNameForDelete: '',

                // Propiedades para Toast UI Calendar
                tuiCalendarInstance: null,
                tuiCalendarCurrentDateRange: '',

                initPage() {
                    const formErrors = @json($errors->getMessages());
                    const oldFormType = "{{ old('_form_type') }}";

                    if (this.showCreateModal || (Object.keys(formErrors).length > 0 && oldFormType === 'create')) {
                        this.showCreateModal = true;
                    }
                    if (this.showEditModal || (Object.keys(formErrors).length > 0 && oldFormType === 'edit')) {
                        if (this.appointmentToEdit && this.appointmentToEdit.id) {
                            if (this.appointmentToEdit.scheduled_at) {
                                const scheduledDate = new Date(this.appointmentToEdit.scheduled_at);
                                this.appointmentToEdit.scheduled_at_date = scheduledDate.toISOString().substring(0,10);
                                this.appointmentToEdit.scheduled_at_time = scheduledDate.toTimeString().substring(0,5);
                            }
                            this.appointmentToEdit.extrasArray = this.appointmentToEdit.extra_services
                                ? this.appointmentToEdit.extra_services.map(es => es.extra_service_id.toString())
                                : [];
                            this.showEditModal = true;
                        }
                    }

                    if (this.activeView === 'calendar') {
                        this.$nextTick(() => this.initializeNewCalendar());
                    }
                },

                switchToTableView() {
                    this.activeView = 'table';
                },
                switchToCalendarView() {
                    this.activeView = 'calendar';
                    this.$nextTick(() => {
                        this.initializeNewCalendar();
                    });
                },

                initializeNewCalendar() {
                    if (this.activeView !== 'calendar') return;

                    // Reintentar hasta que Toast UI Calendar esté cargado
                    if (typeof tui === 'undefined' || typeof tui.Calendar === 'undefined') {
                        console.warn("Toast UI Calendar library not loaded yet. Retrying...");
                        setTimeout(() => this.initializeNewCalendar(), 300);
                        return;
                    }

                    const calendarEl = document.getElementById('tuiCalendarContainer');
                    if (!calendarEl) {
                        console.warn("Calendar container 'tuiCalendarContainer' not found.");
                        return;
                    }

                    // Si ya existe instancia, destruirla para reinicializar
                    if (this.tuiCalendarInstance) {
                        this.tuiCalendarInstance.destroy();
                        this.tuiCalendarInstance = null;
                    }

                    this.tuiCalendarInstance = new tui.Calendar(calendarEl, {
                        defaultView: 'week',
                        useCreationPopup: false,
                        useDetailPopup: false,
                        taskView: false,
                        scheduleView: ['time'],
                        calendars: [
                            { id: 'appointments', name: 'Appointments', backgroundColor: '#3b82f6', borderColor: '#3b82f6', color: '#ffffff' }
                        ],
                        template: {
                            monthDayname(dayname) {
                                return `<span class="toastui-calendar-dayname-date">${dayname.label}</span>`;
                            },
                            time(schedule) {
                                return `<strong>${schedule.title}</strong>`;
                            }
                        },
                        week: {
                            showTimezoneCollapseButton: true,
                            timezonesCollapsed: false,
                            eventView: ['time'],
                            hourStart: 8,
                            hourEnd: 22,
                            daynames: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']
                        },
                        month: {
                            daynames: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                            startDayOfWeek: 1,
                            narrowWeekend: false,
                            visibleWeeksCount: 0
                        },
                        timezone: {
                            zones: [{ timezoneName: Intl.DateTimeFormat().resolvedOptions().timeZone, displayLabel: 'Local' }],
                        }
                    });

                    // Cuando el calendario termine de renderizar, actualizar rango y cargar eventos
                    this.tuiCalendarInstance.on('render', () => {
                        this.updateCalendarDateRange();
                    });

                    // Al hacer clic en un evento
                    this.tuiCalendarInstance.on('clickEvent', async (eventObj) => {
                        const appointmentId = eventObj.event.raw.id; // asumimos que 'id' viene en raw
                        if (appointmentId) {
                            try {
                                // Endpoint para obtener detalles: define en tu controlador un método que retorne JSON de detalles
                                const response = await fetch(`{{ url('admin/api/appointments') }}/${appointmentId}`);
                                if (!response.ok) throw new Error(`Failed to fetch appointment details: ${response.statusText}`);
                                const appointmentDetails = await response.json();
                                this.viewAppointment(appointmentDetails);
                            } catch (error) {
                                console.error('Error fetching appointment details for calendar click:', error);
                                alert('Could not load appointment details. ' + error.message);
                            }
                        }
                    });

                    // Cuando se seleccione un rango de fecha/hora (opcional para crear)
                    this.tuiCalendarInstance.on('selectDateTime', (info) => {
                        // Podrías precargar create modal con fecha/hora
                        // this.showCreateModal = true;
                        // this.preloadCreateDate = info.start;
                    });

                    this.tuiCalendarInstance.render();
                },

                loadCalendarEvents() {
                    if (!this.tuiCalendarInstance) {
                        console.warn("TUI Calendar instance not available for loading events.");
                        return;
                    }

                    const startDate = this.tuiCalendarInstance.getDateRangeStart().toDate();
                    const endDate = this.tuiCalendarInstance.getDateRangeEnd().toDate();

                    const apiStartDate = `${startDate.getFullYear()}-${String(startDate.getMonth()+1).padStart(2,'0')}-${String(startDate.getDate()).padStart(2,'0')}`;
                    const apiEndDate = `${endDate.getFullYear()}-${String(endDate.getMonth()+1).padStart(2,'0')}-${String(endDate.getDate()).padStart(2,'0')}`;

                    fetch(`{{ route('admin.api.calendar.events') }}?start=${apiStartDate}&end=${apiEndDate}`)
                        .then(response => {
                            if (!response.ok) throw new Error(`Network response was not ok: ${response.statusText}`);
                            return response.json();
                        })
                        .then(events => {
                            this.tuiCalendarInstance.clear();
                            this.tuiCalendarInstance.createEvents(events.map(evt => ({
                                id: evt.id,
                                calendarId: 'appointments',
                                title: evt.title,
                                start: evt.start,
                                end: evt.end,
                                raw: {
                                    id: evt.id,
                                    client: evt.clientName,
                                    service: evt.serviceName,
                                    status: evt.status,
                                    monto_final: evt.monto_final || ''
                                }
                            })));
                        })
                        .catch(error => {
                            console.error('Error fetching or processing calendar events:', error);
                            alert('Error loading appointments: ' + error.message);
                        });

                    console.log('hola')
                },

                updateCalendarDateRange() {
                    if (!this.tuiCalendarInstance) return;
                    const viewName = this.tuiCalendarInstance.getViewName();
                    const date = this.tuiCalendarInstance.getDate().toDate();
                    let rangeText = '';
                    const options = { year: 'numeric', month: 'long', day: 'numeric' };

                    if (viewName === 'month') {
                        rangeText = date.toLocaleDateString(undefined, { year: 'numeric', month: 'long' });
                    } else if (viewName === 'week') {
                        const start = this.tuiCalendarInstance.getDateRangeStart().toDate();
                        const end = this.tuiCalendarInstance.getDateRangeEnd().toDate();
                        rangeText = `${start.toLocaleDateString(undefined, options)} - ${end.toLocaleDateString(undefined, options)}`;
                    } else if (viewName === 'day') {
                        rangeText = date.toLocaleDateString(undefined, options);
                    }

                    this.tuiCalendarCurrentDateRange = rangeText;
                    this.loadCalendarEvents();
                },

                editAppointment(appointmentData) {
                    if (!appointmentData) return;
                    this.appointmentToEdit = JSON.parse(JSON.stringify(appointmentData));
                    if (this.appointmentToEdit && this.appointmentToEdit.scheduled_at) {
                        const dt = new Date(this.appointmentToEdit.scheduled_at);
                        this.appointmentToEdit.scheduled_at_date = dt.toISOString().substring(0,10);
                        this.appointmentToEdit.scheduled_at_time = dt.toTimeString().substring(0,5);
                    }
                    this.appointmentToEdit.extrasArray = this.appointmentToEdit.extra_services
                        ? this.appointmentToEdit.extra_services.map(es => es.extra_service_id.toString())
                        : [];
                    this.showEditModal = true;
                },

                viewAppointment(appointmentData) {
                    if (!appointmentData) return;
                    this.appointmentToView = appointmentData;
                    this.showViewModal = true;
                }
            };
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('appointmentsPageData', appointmentsPageData);
        });
    </script>
@endsection