<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceVehiclePrice;
use App\Models\VehicleType;
use App\Models\Category;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        // Buscamos la categoría "Mobile Detailing"
        $category = Category::where('name', 'Mobile Detailing')->first();

        if (! $category) {
            // Si la categoría no existe, puede crearse aquí o simplemente detener el seeder.
            // Category::create(['name' => 'Mobile Detailing']);
            return;
        }

        // Definimos los 4 servicios con sus datos y sus precios por tipo de vehículo
        $services = [
            [
                'name'           => 'Premium Basic Wash',
                'tagline'        => '',
                'description'    => 'Exterior hand wash, general interior vacuuming, glass, dashboard, and door cleaning',
                'recommendation' => 'Ideal for keeping your car clean and presentable every week. Perfect for cars in good condition that only need basic maintenance.',
                'prices'         => [
                    'Sedan'               => 175.00,
                    'SUV'                 => 195.00,
                    'Full Size Truck/Van' => 215.00,
                    'XL/Elevated Vehicle' => 235.00,
                ],
            ],
            [
                'name'           => 'Full Detail (Interior + Exterior)',
                'tagline'        => '',
                'description'    => 'Hand wash with premium shampoo, pressure washer cleaning, thorough detailing by sections (tires, nooks, and hidden corners), deep vacuuming + complete interior wipe cleaning plus ceramic exterior, plastic and glass conditioning, sparkling scent finish',
                'recommendation' => 'For clients who want a real transformation inside and out.',
                'prices'         => [
                    'Sedan'               => 280.00,
                    'SUV'                 => 300.00,
                    'Full Size Truck/Van' => 320.00,
                    'XL/Elevated Vehicle' => 340.00,
                ],
            ],
            [
                'name'           => 'Deep Interior & Exterior',
                'tagline'        => '',
                'description'    => 'Cat/dog hair removal, removal of tough stains (vomit, spills), disinfection and odor neutralization, deep cleaning of seats, carpets, seatbelts, and headliner',
                'recommendation' => 'Price may vary slightly depending on the level of dirt.',
                'prices'         => [
                    'Sedan'               => 320.00,
                    'SUV'                 => 340.00,
                    'Full Size Truck/Van' => 360.00,
                    'XL/Elevated Vehicle' => 380.00,
                ],
            ],
            [
                'name'           => 'Detail + Professional Polish',
                'tagline'        => '',
                'description'    => 'Complete detailing, professional paint polishing, removal of minor scratches and scuffs, deep shine restoration',
                'recommendation' => 'The best option for demanding cars and customers who want the best.',
                'prices'         => [
                    'Sedan'               => 390.00,
                    'SUV'                 => 410.00,
                    'Full Size Truck/Van' => 430.00,
                    'XL/Elevated Vehicle' => 450.00,
                ],
            ],
        ];

        foreach ($services as $data) {
            // Creamos o recuperamos el servicio según el nombre
            $service = Service::firstOrCreate(
                ['name' => $data['name']],
                [
                    'category_id'    => $category->id,
                    'tagline'        => $data['tagline'],
                    'description'    => $data['description'],
                    'recommendation' => $data['recommendation'],
                ]
            );

            // Asignamos los precios para cada tipo de vehículo
            foreach ($data['prices'] as $vehicleName => $price) {
                $vt = VehicleType::where('name', $vehicleName)->first();
                if ($vt) {
                    ServiceVehiclePrice::updateOrCreate(
                        [
                            'service_id'      => $service->id,
                            'vehicle_type_id' => $vt->id,
                        ],
                        [
                            'price' => $price,
                        ]
                    );
                }
            }
        }
    }
}