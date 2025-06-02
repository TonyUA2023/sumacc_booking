<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('appointment_id')
                  ->constrained('appointments')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('status', 50)->default('Pending');
            $table->string('method', 50)->nullable();
            $table->timestampTz('paid_at')->nullable();

            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index('appointment_id', 'idx_payments_appointment_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
