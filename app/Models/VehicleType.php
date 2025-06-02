<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleType extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Relación con ServiceVehiclePrice (N registros)
     */
    public function serviceVehiclePrices(): HasMany
    {
        return $this->hasMany(ServiceVehiclePrice::class);
    }

    /**
     * Relación con Appointment (N registros)
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}