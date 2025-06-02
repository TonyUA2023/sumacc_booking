<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Importante para ejecutar SQL crudo

class ModifyStatusEnumInAppointmentsAndHistoriesTable extends Migration
{
    public function up()
    {
        // --- Modificar la tabla appointments ---
        // Es complejo modificar un ENUM directamente en todos los SGBD con el Schema Builder.
        // A menudo se requiere SQL crudo, especialmente si hay datos y constraints.

        // PostgreSQL ejemplo:
        // Paso 1: Eliminar la constraint si existe explícitamente (el ENUM ya actúa como una)
        // Si tu error mencionaba 'appointments_status_check', puede que sea una check constraint adicional.
        // Si la constraint es implícita por el tipo ENUM, este paso podría no ser necesario o diferente.
        // DB::statement('ALTER TABLE appointments DROP CONSTRAINT IF EXISTS appointments_status_check;'); // Ajusta el nombre si es diferente

        // Paso 2: Cambiar el tipo de la columna a VARCHAR temporalmente (si hay datos que mapear)
        // O, si puedes permitirte perder los valores de status temporalmente o no hay datos:
        // DB::statement('ALTER TABLE appointments ALTER COLUMN status TYPE VARCHAR(255);');

        // Paso 3: Crear el nuevo tipo ENUM en inglés (si no existe)
        DB::statement("DO $$ BEGIN IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'appointment_status_enum_en') THEN CREATE TYPE appointment_status_enum_en AS ENUM ('Pending', 'Accepted', 'Rejected', 'Completed', 'Cancelled', 'In Progress', 'Scheduled'); END IF; END $$;");

        // Paso 4: Modificar la columna para usar el nuevo tipo ENUM
        // Primero, asegurémonos de que la columna pueda ser nula temporalmente o tenga un default válido si la convertimos directamente
        // La forma más segura es cambiar a un tipo intermedio, actualizar datos, y luego cambiar al nuevo ENUM.
        // Esto es un ejemplo simplificado. En producción, harías un mapeo de datos viejos a nuevos.
        DB::statement("ALTER TABLE appointments ALTER COLUMN status DROP DEFAULT;"); // Quitar default viejo
        DB::statement("ALTER TABLE appointments ALTER COLUMN status TYPE appointment_status_enum_en USING status::text::appointment_status_enum_en;");
        DB::statement("ALTER TABLE appointments ALTER COLUMN status SET DEFAULT 'Pending';");


        // --- Modificar la tabla appointment_status_histories ---
        DB::statement("ALTER TABLE appointment_status_histories ALTER COLUMN old_status TYPE appointment_status_enum_en USING old_status::text::appointment_status_enum_en;");
        DB::statement("ALTER TABLE appointment_status_histories ALTER COLUMN new_status TYPE appointment_status_enum_en USING new_status::text::appointment_status_enum_en;");

        // Nota: La sintaxis exacta puede variar ligeramente si usas MySQL u otro SGBD.
        // MySQL no tiene tipos ENUM separados que se puedan reusar fácilmente como PostgreSQL.
        // Para MySQL, modificarías la definición de la columna directamente:
        // DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('Pending', 'Accepted', 'Rejected', 'Completed', 'Cancelled', 'In Progress', 'Scheduled') DEFAULT 'Pending';");
        // DB::statement("ALTER TABLE appointment_status_histories MODIFY COLUMN old_status ENUM('Pending', 'Accepted', 'Rejected', 'Completed', 'Cancelled', 'In Progress', 'Scheduled');");
        // DB::statement("ALTER TABLE appointment_status_histories MODIFY COLUMN new_status ENUM('Pending', 'Accepted', 'Rejected', 'Completed', 'Cancelled', 'In Progress', 'Scheduled');");
    }

    public function down()
    {
        // Revertir los cambios es igualmente complejo.
        // Deberías definir los pasos para volver al ENUM en español.
        // Por simplicidad, lo omito, pero en un proyecto real es crucial.
        // Ejemplo para PostgreSQL (revertir a un ENUM en español que DEBE existir):
        DB::statement("DO $$ BEGIN IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'appointment_status_enum_es') THEN CREATE TYPE appointment_status_enum_es AS ENUM ('Pendiente','Aceptado','Rechazado','Realizado'); END IF; END $$;");

        DB::statement("ALTER TABLE appointments ALTER COLUMN status DROP DEFAULT;");
        DB::statement("ALTER TABLE appointments ALTER COLUMN status TYPE appointment_status_enum_es USING status::text::appointment_status_enum_es;"); // Asume mapeo
        DB::statement("ALTER TABLE appointments ALTER COLUMN status SET DEFAULT 'Pendiente';");

        DB::statement("ALTER TABLE appointment_status_histories ALTER COLUMN old_status TYPE appointment_status_enum_es USING old_status::text::appointment_status_enum_es;");
        DB::statement("ALTER TABLE appointment_status_histories ALTER COLUMN new_status TYPE appointment_status_enum_es USING new_status::text::appointment_status_enum_es;");

        // Si creaste tipos ENUM separados y quieres eliminarlos (cuidado si están en uso):
        // DB::statement("DROP TYPE IF EXISTS appointment_status_enum_en;");
    }
}