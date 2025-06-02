<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'tagline',
        'description',
        'recommendation',
    ];

    /**
     * Un servicio pertenece a una categoría.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Un servicio puede tener precios diferentes según el tipo de vehículo.
     */
    public function serviceVehiclePrices(): HasMany
    {
        return $this->hasMany(ServiceVehiclePrice::class);
    }

    /**
     * Un servicio puede estar en muchas citas (a través de appointment.service_id).
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}