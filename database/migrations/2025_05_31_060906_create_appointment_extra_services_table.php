<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentExtraServicesTable extends Migration
{
    public function up()
    {
        Schema::create('appointment_extra_services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('appointment_id')
                  ->constrained('appointments')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreignId('extra_service_id')
                  ->constrained('extra_services')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');

            $table->integer('quantity')->unsigned()->default(1);
            $table->decimal('unit_price', 10, 2)->unsigned();

            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();

            $table->unique(['appointment_id','extra_service_id'], 'uniq_apt_extra');
        });

        Schema::table('appointment_extra_services', function (Blueprint $table) {
            $table->index('appointment_id', 'idx_aes_appointment_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointment_extra_services');
    }
}