<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display dashboard overview with stats and charts.
     */
    public function index()
    {
        // 1) Counts by status
        $pendingCount   = Appointment::where('status', 'Pending')->count();
        $acceptedCount  = Appointment::whereIn('status', ['Accepted', 'Confirmed'])->count();
        $completedCount = Appointment::where('status', 'Completed')->count();

        // 2) Total revenue (assuming appointments have a 'monto_final' column)
        $totalRevenue = Appointment::where('status', 'Completed')
                            ->sum('monto_final');

        // 3) Next 5 upcoming appointments (ordered by scheduled_at)
        $nextAppointments = Appointment::with(['client', 'service'])
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at', 'asc')
            ->limit(5)
            ->get();

        // 4) Total number of clients and services (simple overview)
        $totalClients  = Client::count();
        $totalServices = Service::count();

        // 5) Chart data for last 6 months: appointments per month (PostgreSQL uses TO_CHAR)
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();
        $appointmentCounts = Appointment::select(
                DB::raw("TO_CHAR(scheduled_at, 'YYYY-MM') as month"),
                DB::raw("COUNT(*) as count")
            )
            ->where('scheduled_at', '>=', $sixMonthsAgo)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Ensure we have an entry (0) for each of the last 6 months
        $monthsLabels = [];
        $monthsCounts = [];
        for ($i = 5; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $key = $dt->format('Y-m');
            $display = $dt->format('M Y');
            $monthsLabels[] = $display;
            $monthsCounts[] = $appointmentCounts[$key] ?? 0;
        }

        // 6) Chart data for revenue per month (last 6 months)
        $revenueData = Appointment::select(
                DB::raw("TO_CHAR(scheduled_at, 'YYYY-MM') as month"),
                DB::raw("SUM(monto_final) as revenue")
            )
            ->where('scheduled_at', '>=', $sixMonthsAgo)
            ->where('status', 'Completed')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('revenue', 'month')
            ->toArray();

        $monthsRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $dt = Carbon::now()->subMonths($i);
            $key = $dt->format('Y-m');
            $monthsRevenue[] = round($revenueData[$key] ?? 0, 2);
        }

        return view('admin.dashboard', compact(
            'pendingCount',
            'acceptedCount',
            'completedCount',
            'totalRevenue',
            'nextAppointments',
            'totalClients',
            'totalServices',
            'monthsLabels',
            'monthsCounts',
            'monthsRevenue'
        ));
    }
}