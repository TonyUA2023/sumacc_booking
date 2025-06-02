<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExtraService extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    /**
     * Un extra puede estar asociado a muchas citas (pivot).
     */
    public function appointmentExtraServices(): HasMany
    {
        return $this->hasMany(AppointmentExtraService::class);
    }
}