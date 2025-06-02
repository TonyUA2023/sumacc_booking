<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // No se usa en index(), pero es bueno tenerlo si se expande
use App\Models\Appointment;

class DashboardController extends Controller
{
    /**
     * Show basic stats on the admin dashboard:
     * • Count of appointments per status  
     * • Next upcoming appointments  
     * • Total revenue from completed appointments
     */
    public function index()
    {
        // Asegúrate de que estos strings coincidan con los valores ENUM/status en tu BD (en inglés)
        $pendingCount   = Appointment::where('status', 'Pending')->count();
        $acceptedCount  = Appointment::where('status', 'Accepted')->count(); // O 'Confirmed' si ese es el término que usas
        $rejectedCount  = Appointment::where('status', 'Rejected')->count();
        $completedCount = Appointment::where('status', 'Completed')->count();

        $nextAppointments = Appointment::with(['client', 'service']) // Añadido 'service' para eager loading
            ->where('status', '!=', 'Completed') // Opcional: solo mostrar las que no estén completadas
            ->where('status', '!=', 'Cancelled') // Opcional: solo mostrar las que no estén canceladas
            ->where('status', '!=', 'Rejected')  // Opcional: solo mostrar las que no estén rechazadas
            ->where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at', 'asc')
            ->take(5)
            ->get();

        $totalRevenue = Appointment::where('status', 'Completed')->sum('monto_final');

        return view('admin.dashboard', compact(
            'pendingCount',
            'acceptedCount',
            'rejectedCount',
            'completedCount',
            'nextAppointments',
            'totalRevenue'
        ));
    }
}