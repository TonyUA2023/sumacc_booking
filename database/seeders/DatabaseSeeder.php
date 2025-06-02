<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // IMPORTANTE: el orden importa, porque algunos seeders dependen 
        // de tablas creadas por migraciones anteriores.
        $this->call([
            VehicleTypesTableSeeder::class,
            CategoriesTableSeeder::class,
            AdminsTableSeeder::class,
            ExtraServicesTableSeeder::class,
            ServicesTableSeeder::class
            // Si tuvieras más seeders, ponlos aquí en el orden lógico
        ]);
    }
}