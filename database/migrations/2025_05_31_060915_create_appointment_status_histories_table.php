<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentStatusHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('appointment_status_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('appointment_id')
                  ->constrained('appointments')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->enum('old_status', ['Pending','Accepted','Rejected','Completed']);
            $table->enum('new_status', ['Pending','Accepted','Rejected','Completed']);
            $table->timestampTz('changed_at')->useCurrent();

            $table->foreignId('changed_by_admin_id')
                  ->constrained('admins')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->timestampTz('created_at')->useCurrent();
            $table->timestampTz('updated_at')->useCurrent();
        });

        Schema::table('appointment_status_histories', function (Blueprint $table) {
            $table->index('appointment_id', 'idx_ash_appointment_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointment_status_histories');
    }
}