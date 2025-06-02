<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientAddressController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ExtraServiceController;
use App\Http\Controllers\AppointmentController; // Para la ruta pública /appointments/{id}
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AppointmentAdminController; // Controlador para el CRUD de admin
use App\Http\Controllers\PageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('public.index');
})->name('public.home');

Route::get('/services', [PageController::class, 'servicesPage'])
     ->name('services.page');

Route::get('/services/{service}/book', [BookingController::class, 'create'])
    ->name('services.book');

// Ruta pública para guardar citas creadas por clientes
Route::post('/appointments', [BookingController::class, 'store'])
     ->name('appointments.store'); // Esta es la que usa el formulario público

Route::get('/booking/unavailable-times', [BookingController::class, 'getUnavailableTimesForDate'])
     ->name('booking.unavailable_times');

// List all extra services (GET /extra-services)
Route::get('/extra-services', [ExtraServiceController::class, 'index']);

// Create or retrieve a client by email (POST /clients)
Route::post('/clients', [ClientController::class, 'storeOrGet']);

// Create a new address for a client (POST /client-addresses)
Route::post('/client-addresses', [ClientAddressController::class, 'store']);

// Show one appointment’s details (GET /appointments/{id})
Route::get('/appointments/{id}', [AppointmentController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Admin Login Form (GET /admin/login)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');

    // Process Login (POST /admin/login)
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    // Protected admin routes
    Route::middleware('auth:admin')->group(function () {

        // Dashboard (GET /admin/dashboard)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        
        Route::get('/appointments', [AppointmentAdminController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/create', [AppointmentAdminController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [AppointmentAdminController::class, 'store'])->name('appointments.store'); // Esta ruta podría tener el mismo nombre que la pública, pero está en el grupo admin.
        Route::get('/appointments/{id}', [AppointmentAdminController::class, 'show'])->name('appointments.show');
        Route::get('/appointments/{appointment}/edit', [AppointmentAdminController::class, 'edit'])->name('appointments.edit');
        Route::put('/appointments/{appointment}', [AppointmentAdminController::class, 'update'])->name('appointments.update');
        Route::delete('/appointments/{appointment}', [AppointmentAdminController::class, 'destroy'])->name('appointments.destroy');
        Route::get('/admin/api/calendar-events', [AppointmentAdminController::class, 'calendarEvents'])
        // Ruta para obtener eventos para el calendario (Toast UI Calendar u otros)
            ->name('admin.api.calendar.events');
        Route::get('/api/calendar-events', [AppointmentAdminController::class, 'calendarEvents'])->name('api.calendar.events');

        // NUEVA RUTA para obtener detalles de una cita en JSON para el modal de visualización desde el calendario
        Route::get('/api/appointments/{appointment}/details', [AppointmentAdminController::class, 'getAppointmentJsonDetails'])->name('api.appointments.details');

        // Actualizar solamente el estado de la cita:
        Route::put('appointments/{id}/status', [AppointmentAdminController::class, 'updateStatus'])
            ->name('appointments.updateStatus'); // Mantenida por si se usa en algún lugar.
        Route::patch('/appointments/{id}/status', [AppointmentAdminController::class, 'updateStatus']) //  PATCH es más semántico para actualizaciones parciales
             ->name('appointments.updateStatusPatch'); // Cambié el nombre para evitar conflicto si decides mantener ambas PUT/PATCH para el mismo controller method. Si sólo usas una, puedes usar el nombre original.

        // Admin Services CRUD
        Route::get('/services', [AdminServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [AdminServiceController::class, 'store'])->name('services.store');
        Route::get('/services/create', [AdminServiceController::class, 'create'])->name('services.create');
        Route::get('/services/{service}', [AdminServiceController::class, 'show'])->name('services.show');
        Route::get('/services/{service}/edit', [AdminServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');

        // Admin Clients CRUD
        Route::get('/clients', [AdminClientController::class, 'index'])->name('clients.index');
        Route::post('/clients', [AdminClientController::class, 'store'])->name('clients.store');
        Route::get('/clients/create', [AdminClientController::class, 'create'])->name('clients.create');
        Route::get('/clients/{client}', [AdminClientController::class, 'show'])->name('clients.show');
        Route::get('/clients/{client}/edit', [AdminClientController::class, 'edit'])->name('clients.edit');
        Route::put('/clients/{client}', [AdminClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{client}', [AdminClientController::class, 'destroy'])->name('clients.destroy');
        
        // ... Aquí irían otras rutas de admin como gestión de servicios, clientes, usuarios, etc. ...

    });
});