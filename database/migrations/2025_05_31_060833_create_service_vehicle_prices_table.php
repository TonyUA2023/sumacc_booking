<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceVehiclePricesTable extends Migration
{
    public function up()
    {
        Schema::create('service_vehicle_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreignId('vehicle_type_id')
                  ->constrained('vehicle_types')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->decimal('price', 10, 2)->default(0.00)->unsigned();
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();

            $table->unique(['service_id', 'vehicle_type_id'], 'unique_service_vehicle');
        });

        Schema::table('service_vehicle_prices', function (Blueprint $table) {
            $table->index('service_id', 'idx_svp_service_id');
            $table->index('vehicle_type_id', 'idx_svp_vehicle_type_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_vehicle_prices');
    }
}