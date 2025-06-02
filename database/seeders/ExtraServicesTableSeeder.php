<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExtraService;

class ExtraServicesTableSeeder extends Seeder
{
    public function run()
    {
        $extras = [
            ['name' => 'Aquapel Glass Treatment', 'description' => '', 'price' => 30.00],
            ['name' => 'Leather Treatment',   'description' => '', 'price' => 30.00],
            ['name' => 'Engine Dress',   'description' => '', 'price' => 25.00],
            ['name' => 'Spray Wax',   'description' => '', 'price' => 15.00],
            ['name' => 'Tree Sap Removal',   'description' => '', 'price' => 30.00],
            // Añade más extras si quieres.
        ];

        foreach ($extras as $extra) {
            ExtraService::firstOrCreate(['name' => $extra['name']], [
                'description' => $extra['description'],
                'price'       => $extra['price']
            ]);
        }
    }
}
