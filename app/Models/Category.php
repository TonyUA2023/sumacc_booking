<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // Como usamos created_at y updated_at de Laravel, no necesitamos configurar timestamps = false
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Una categoría tiene muchos servicios.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}