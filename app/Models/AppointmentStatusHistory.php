<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentStatusHistory extends Model
{
    protected $fillable = [
        'appointment_id',
        'old_status',
        'new_status',
        'changed_at',
        'changed_by_admin_id',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public $timestamps = false; // Como ya guardamos changed_at manualmente.

    /**
     * A qué cita pertenece este histórico.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Qué admin lo cambió.
     */
    public function changedByAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'changed_by_admin_id');
    }
}