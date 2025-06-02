<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypesTableSeeder extends Seeder
{
    public function run()
    {
        $types = ['Sedan', 'SUV', 'FullSize', 'XL'];

        foreach ($types as $type) {
            VehicleType::firstOrCreate(['name' => $type]);
        }
    }
}
