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
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ExtraServiceController as AdminExtraServiceController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas
Route::get('/', function () {
    return view('public.index');
})->name('public.home');

Route::get('/services', [PageController::class, 'servicesPage'])
     ->name('services.page');

Route::get('/services/{service}/book', [BookingController::class, 'create'])
     ->name('services.book');

// Guardar cita desde formulario público
Route::post('/appointments', [BookingController::class, 'store'])
     ->name('appointments.store');

Route::get('/booking/unavailable-times', [BookingController::class, 'getUnavailableTimesForDate'])
     ->name('booking.unavailable_times');

// Extra services públicos
Route::get('/extra-services', [ExtraServiceController::class, 'index']);

// Crear o recuperar cliente por correo
Route::post('/clients', [ClientController::class, 'storeOrGet']);

// Crear nueva dirección para cliente
Route::post('/client-addresses', [ClientAddressController::class, 'store']);

// Mostrar detalle de cita pública
Route::get('/appointments/{id}', [AppointmentController::class, 'show']);

// Show the contact page (GET /contact)
Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');


// Rutas de administración
Route::prefix('admin')->name('admin.')->group(function () {

    // Login administrador
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    // Protegidas por auth:admin
    Route::middleware('auth:admin')->group(function () {

        // Dashboard y Logout
        Route::get('/dashboard', [DashboardController::class, 'index'])
             ->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // ---------------------------------------------------
        // CRUD de Appointments (admin)
        // ---------------------------------------------------
        Route::get('/appointments', [AppointmentAdminController::class, 'index'])
            ->name('appointments.index');
        Route::get('/appointments/create', [AppointmentAdminController::class, 'create'])
            ->name('appointments.create');
        Route::post('/appointments', [AppointmentAdminController::class, 'store'])
            ->name('appointments.store');
        Route::get('/appointments/{appointment}', [AppointmentAdminController::class, 'show'])
            ->name('appointments.show');
        Route::get('/appointments/{appointment}/edit', [AppointmentAdminController::class, 'edit'])
            ->name('appointments.edit');
        Route::put('/appointments/{appointment}', [AppointmentAdminController::class, 'update'])
            ->name('appointments.update');
        Route::delete('/appointments/{appointment}', [AppointmentAdminController::class, 'destroy'])
            ->name('appointments.destroy');

        // ------------ 
        // JSON / AJAX 
        // ------------

        // 1) Eventos para FullCalendar:
        //    → URI final: /admin/api/calendar-events
        //    → Nombre de ruta: admin.api.calendar.events
        Route::get('/api/calendar-events', [AppointmentAdminController::class, 'calendarEvents'])
            ->name('api.calendar.events');

        // 2) Detalles de una cita (JSON) para el modal:
        //    → URI final: /admin/api/appointments/{appointment}/details
        //    → Nombre de ruta: admin.api.appointments.details
        Route::get('/api/appointments/{appointment}/details',
            [AppointmentAdminController::class, 'getAppointmentJsonDetails'])
            ->name('api.appointments.details');

        // 3) Actualizar sólo estado (PATCH):
        //    → URI final: /admin/appointments/{appointment}/status
        //    → Nombre de ruta: admin.appointments.updateStatus
        Route::patch('/appointments/{appointment}/status',
            [AppointmentAdminController::class, 'updateStatus'])
            ->name('appointments.updateStatus');
        // ----------------------------
        // Rutas CRUD para Services (Admin)
        // ----------------------------
        Route::get('/services', [AdminServiceController::class, 'index'])
             ->name('services.index');
        Route::get('/services/create', [AdminServiceController::class, 'create'])
             ->name('services.create');
        Route::post('/services', [AdminServiceController::class, 'store'])
             ->name('services.store');
        Route::get('/services/{service}', [AdminServiceController::class, 'show'])
             ->name('services.show');
        Route::get('/services/{service}/edit', [AdminServiceController::class, 'edit'])
             ->name('services.edit');
        Route::put('/services/{service}', [AdminServiceController::class, 'update'])
             ->name('services.update');
        Route::delete('/services/{service}', [AdminServiceController::class, 'destroy'])
             ->name('services.destroy');

        // ----------------------------
        // CRUD Clients (Admin)
        // ----------------------------
        Route::get('/clients', [AdminClientController::class, 'index'])
             ->name('clients.index');
        Route::get('/clients/create', [AdminClientController::class, 'create'])
             ->name('clients.create');
        Route::post('/clients', [AdminClientController::class, 'store'])
             ->name('clients.store');
        Route::get('/clients/{client}', [AdminClientController::class, 'show'])
             ->name('clients.show');
        Route::get('/clients/{client}/edit', [AdminClientController::class, 'edit'])
             ->name('clients.edit');
        Route::put('/clients/{client}', [AdminClientController::class, 'update'])
             ->name('clients.update');
        Route::delete('/clients/{client}', [AdminClientController::class, 'destroy'])
             ->name('clients.destroy');


                // ----------------------------
        // CRUD Users (Admin)
        // ----------------------------
        Route::get('/users', [AdminUserController::class, 'index'])
             ->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])
             ->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])
             ->name('users.store');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])
             ->name('users.show');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])
             ->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])
             ->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
             ->name('users.destroy');

        Route::get('/settings', [SettingsController::class, 'edit'])
             ->name('settings.edit');
        Route::put('/settings', [SettingsController::class, 'update'])
             ->name('settings.update');
        
        // CRUD Extra Services (Admin)
        Route::get('/extra-services', [AdminExtraServiceController::class, 'index'])
             ->name('extra-services.index');
        Route::get('/extra-services/create', [AdminExtraServiceController::class, 'create'])
             ->name('extra-services.create');
        Route::post('/extra-services', [AdminExtraServiceController::class, 'store'])
             ->name('extra-services.store');
        Route::get('/extra-services/{extraService}', [AdminExtraServiceController::class, 'show'])
             ->name('extra-services.show');
        Route::get('/extra-services/{extraService}/edit', [AdminExtraServiceController::class, 'edit'])
             ->name('extra-services.edit');
        Route::put('/extra-services/{extraService}', [AdminExtraServiceController::class, 'update'])
             ->name('extra-services.update');
        Route::delete('/extra-services/{extraService}', [AdminExtraServiceController::class, 'destroy'])
             ->name('extra-services.destroy');

        // … Otras rutas de admin si son necesarias …
    });
});