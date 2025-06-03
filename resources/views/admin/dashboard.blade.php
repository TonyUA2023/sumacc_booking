{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layout')

@section('title', 'Admin Dashboard - SUMACC')
@section('page-title', 'Dashboard Overview')

@section('content')
    {{-- Stats Cards Section --}}
    <div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 mr-4 text-orange-600 bg-orange-100 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
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
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"></path>
                    </svg>
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
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
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
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Total Revenue</span>
                    <span class="block text-2xl font-bold text-gray-800">${{ number_format($totalRevenue, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Additional Overview --}}
    <div class="grid grid-cols-1 gap-6 mb-6 sm:grid-cols-2">
        <div class="p-6 bg-white rounded-lg shadow-md">
            <span class="block text-sm font-medium text-gray-500">Total Clients</span>
            <span class="block text-2xl font-bold text-gray-800">{{ $totalClients }}</span>
        </div>
        <div class="p-6 bg-white rounded-lg shadow-md">
            <span class="block text-sm font-medium text-gray-500">Total Services</span>
            <span class="block text-2xl font-bold text-gray-800">{{ $totalServices }}</span>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
        {{-- Appointments Over Last 6 Months --}}
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-xl font-semibold text-gray-700">Appointments: Last 6 Months</h2>
            <canvas id="apptChart" height="200"></canvas>
        </div>

        {{-- Revenue Over Last 6 Months --}}
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-xl font-semibold text-gray-700">Revenue: Last 6 Months</h2>
            <canvas id="revenueChart" height="200"></canvas>
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
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Date & Time
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Client
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Service
                            </th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Status
                            </th>
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
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $appt->client->first_name }} {{ $appt->client->last_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $appt->client->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $appt->service->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClass = '';
                                        switch (strtolower($appt->status)) {
                                            case 'pending':
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                                break;
                                            case 'accepted':
                                            case 'confirmed':
                                                $statusClass = 'bg-green-100 text-green-800';
                                                break;
                                            case 'rejected':
                                            case 'cancelled':
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
@endsection

@push('scripts')
    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Appointments Chart
            const apptCtx = document.getElementById('apptChart').getContext('2d');
            new Chart(apptCtx, {
                type: 'line',
                data: {
                    labels: @json($monthsLabels),
                    datasets: [{
                        label: 'Appointments',
                        data: @json($monthsCounts),
                        borderColor: 'rgba(59, 130, 246, 1)',       // blue-500
                        backgroundColor: 'rgba(59, 130, 246, 0.2)', // blue-500, 20% opacity
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Revenue Chart
            const revCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthsLabels),
                    datasets: [{
                        label: 'Revenue ($)',
                        data: @json($monthsRevenue),
                        backgroundColor: 'rgba(34, 197, 94, 0.7)', // green-500
                        borderColor: 'rgba(34, 197, 94, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
@endpush