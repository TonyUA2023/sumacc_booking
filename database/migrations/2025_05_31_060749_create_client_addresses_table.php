<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('client_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                  ->constrained('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('street', 200);
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('postal_code', 20);
            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();
        });

        // Índice sobre client_id para acelerar consultas
        Schema::table('client_addresses', function (Blueprint $table) {
            $table->index('client_id', 'idx_client_addresses_client_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_addresses');
    }
}
