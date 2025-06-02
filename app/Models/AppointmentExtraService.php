<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentExtraService extends Model
{
    protected $fillable = [
        'appointment_id',
        'extra_service_id',
        'quantity',
        'unit_price',
    ];

    /**
     * Pivote a la cita.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Pivote al extra service.
     */
    public function extraService(): BelongsTo
    {
        return $this->belongsTo(ExtraService::class);
    }
}