<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // FK al cliente:
            $table->foreignId('client_id')
                  ->constrained('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // FK a la dirección elegida del cliente:
            $table->foreignId('address_id')
                  ->constrained('client_addresses')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            // Fecha y hora programada (con zona horaria):
            $table->timestampTz('scheduled_at');

            // FK al servicio principal:
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            // FK al tipo de vehículo:
            $table->foreignId('vehicle_type_id')
                  ->constrained('vehicle_types')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            // Monto total (servicio + extras):
            $table->decimal('monto_final', 10, 2)->unsigned();

            // Notas:
            $table->text('notas')->nullable();

            // Estado de la cita (ENUM que crearemos manualmente):
            // Para que Laravel lo reconozca, definiremos el ENUM en el Boot de la migración.
            $table->enum('status', ['Pending','Accepted','Rejected','Completed'])
                  ->default('Pending');

            // Quién actualizó por última vez (admin):
            $table->foreignId('updated_by_admin_id')
                  ->nullable()
                  ->constrained('admins')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            // Timestamps de Laravel (created_at = fecha registro, updated_at = última edición)
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();
        });

        // Índices recomendados:
        Schema::table('appointments', function (Blueprint $table) {
            $table->index('client_id', 'idx_appointments_client_id');
            $table->index('address_id', 'idx_appointments_address_id');
            $table->index('scheduled_at', 'idx_appointments_scheduled_at');
            $table->index('status', 'idx_appointments_status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}