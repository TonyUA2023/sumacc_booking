@extends('admin.layout')

@section('title', 'Create New Appointment - SUMACC Admin')

@section('page-title', 'Create New Appointment')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
    <form action="{{ route('admin.appointments.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

            {{-- Sección Cliente --}}
            <div class="md:col-span-1">
                <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                <select id="client_id" name="client_id" required
                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Select a client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->first_name }} {{ $client->last_name }} ({{ $client->email }})
                        </option>
                    @endforeach
                </select>
                @error('client_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                {{-- Opcional: Link para crear nuevo cliente si no existe --}}
                {{-- <a href="{{ route('admin.clients.create') }}" class="mt-1 text-xs text-blue-600 hover:underline">Create New Client</a> --}}
            </div>

            {{-- Sección Dirección (Manual para este ejemplo) --}}
            {{-- El controlador deberá crear un ClientAddress y asociarlo al client_id seleccionado --}}
            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-x-6">
                <div>
                    <label for="address_street" class="block text-sm font-medium text-gray-700">Street Address</label>
                    <input type="text" name="address_street" id="address_street" value="{{ old('address_street') }}" required
                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('address_street')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="address_city" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" name="address_city" id="address_city" value="{{ old('address_city') }}" required
                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('address_city')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="address_state" class="block text-sm font-medium text-gray-700">State/Province (Optional)</label>
                    <input type="text" name="address_state" id="address_state" value="{{ old('address_state') }}"
                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
                <div>
                    <label for="address_postal_code" class="block text-sm font-medium text-gray-700">ZIP/Postal Code (Optional)</label>
                    <input type="text" name="address_postal_code" id="address_postal_code" value="{{ old('address_postal_code') }}"
                           class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>


            {{-- Sección Servicio y Vehículo --}}
            <div class="md:col-span-1">
                <label for="service_id" class="block text-sm font-medium text-gray-700">Service</label>
                <select id="service_id" name="service_id" required
                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Select a service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-1">
                <label for="vehicle_type_id" class="block text-sm font-medium text-gray-700">Vehicle Type</label>
                <select id="vehicle_type_id" name="vehicle_type_id" required
                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Select a vehicle type</option>
                    @foreach($vehicleTypes as $vehicleType)
                        <option value="{{ $vehicleType->id }}" {{ old('vehicle_type_id') == $vehicleType->id ? 'selected' : '' }}>
                            {{ $vehicleType->name }}
                        </option>
                    @endforeach
                </select>
                @error('vehicle_type_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            
            {{-- Espacio para ocupar la tercera columna en la fila de servicio/vehículo si la hay --}}
            <div class="hidden lg:block"></div>


            {{-- Fecha y Hora --}}
            <div class="md:col-span-1">
                <label for="scheduled_at_date" class="block text-sm font-medium text-gray-700">Scheduled Date</label>
                <input type="date" name="scheduled_at_date" id="scheduled_at_date" value="{{ old('scheduled_at_date') }}" required
                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('scheduled_at_date')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-1">
                <label for="scheduled_at_time" class="block text-sm font-medium text-gray-700">Scheduled Time</label>
                <input type="time" name="scheduled_at_time" id="scheduled_at_time" value="{{ old('scheduled_at_time') }}" required
                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('scheduled_at_time')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Status --}}
            <div class="md:col-span-1">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" required
                        class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ old('status', 'Pending') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Servicios Extra (Opcional) --}}
            @if($extraServices->count() > 0)
            <div class="md:col-span-3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Extra Services (Optional)</label>
                <div class="p-4 border border-gray-200 rounded-md max-h-48 overflow-y-auto">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                        @foreach($extraServices as $extra)
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="extras[]" value="{{ $extra->id }}"
                                       {{ is_array(old('extras')) && in_array($extra->id, old('extras')) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm text-gray-700">{{ $extra->name }} (+${{ number_format($extra->price, 2) }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @error('extras.*')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            @endif

            {{-- Monto Final y Notas --}}
            <div class="md:col-span-1">
                <label for="monto_final" class="block text-sm font-medium text-gray-700">Final Amount ($)</label>
                <input type="number" name="monto_final" id="monto_final" value="{{ old('monto_final') }}" step="0.01" min="0" required
                       class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       placeholder="e.g., 150.00">
                @error('monto_final')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                 {{-- Podrías añadir JS para calcular esto basado en selecciones y mostrarlo aquí --}}
            </div>
            
            <div class="md:col-span-2">
                <label for="notas" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                <textarea id="notas" name="notas" rows="3"
                          class="block w-full px-3 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                          placeholder="Any special instructions or internal notes...">{{ old('notas') }}</textarea>
                @error('notas')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Botones de Acción --}}
        <div class="pt-8 mt-8 border-t border-gray-200">
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.appointments.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create Appointment
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
{{-- <script>
    // Aquí podrías añadir JS para:
    // - Cargar dinámicamente direcciones cuando se selecciona un cliente.
    // - Calcular dinámicamente el monto_final.
    // - Inicializar un date/time picker más avanzado si es necesario.
</script> --}}
@endpush