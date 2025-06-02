@extends('admin.layout')

@section('title', 'Admin Dashboard - SUMACC')

@section('page-title', 'Dashboard Overview')

@section('content')
    {{-- Stats Cards Section --}}
    <div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-4 ml-0">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 text-orange-600 bg-orange-100 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Pending Appointments</span>
                    <span class="block text-2xl font-bold text-gray-800">{{ $pendingCount }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 text-green-600 bg-green-100 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Accepted Appointments</span>
                    <span class="block text-2xl font-bold text-gray-800">{{ $acceptedCount }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 text-blue-600 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Completed Appointments</span>
                    <span class="block text-2xl font-bold text-gray-800">{{ $completedCount }}</span>
                </div>
            </div>
        </div>
        
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 text-indigo-600 bg-indigo-100 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Total Revenue</span>
                    <span class="block text-2xl font-bold text-gray-800">${{ number_format($totalRevenue, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Upcoming Appointments Section --}}
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-xl font-semibold text-gray-700">Next 5 Upcoming Appointments</h2>
        @if($nextAppointments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Date & Time
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Client
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Service
                            </th>
                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Status
                            </th>
                            {{-- <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">View</span>
                            </th> --}}
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($nextAppointments as $appt)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appt->scheduled_at->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $appt->scheduled_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $appt->client->first_name }} {{ $appt->client->last_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $appt->client->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appt->service->name }}</div>
                                    {{-- You might want to display vehicle type too --}}
                                    {{-- <div class="text-sm text-gray-500">{{ $appt->vehicleType->name }}</div> --}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = '';
                                        switch (strtolower($appt->status)) {
                                            case 'pending':
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                                break;
                                            case 'accepted':
                                            case 'confirmed': // Added confirmed as example
                                                $statusClass = 'bg-green-100 text-green-800';
                                                break;
                                            case 'rejected':
                                            case 'cancelled': // Added cancelled
                                                $statusClass = 'bg-red-100 text-red-800';
                                                break;
                                            case 'completed':
                                                $statusClass = 'bg-blue-100 text-blue-800';
                                                break;
                                            default:
                                                $statusClass = 'bg-gray-100 text-gray-800';
                                        }
                                    @endphp
                                    <span class="inline-flex px-2 text-xs font-semibold leading-5 {{ $statusClass }} rounded-full">
                                        {{ ucfirst($appt->status) }}
                                    </span>
                                </td>
                                {{-- <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">View</a>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No upcoming appointments.</p>
        @endif

        <div class="mt-6 text-right">
            <a href="{{ route('admin.appointments.index') }}" 
               class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                View All Appointments
            </a>
        </div>
    </div>

    {{-- El botón de Logout ya está en el header del layout 'admin.layout', por lo que no es necesario aquí --}}

@endsection

@push('styles')
    {{-- Si necesitas estilos específicos para esta página de dashboard --}}
@endpush

@push('scripts')
    {{-- Si necesitas scripts específicos para esta página de dashboard --}}
@endpush