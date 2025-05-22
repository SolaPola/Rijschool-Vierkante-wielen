<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            [
                'type' => 'Package1',
                'number_of_lessons' => 10,
                'price_per_lesson' => 45.00,
                'isactive' => true,
                'remark' => 'Basic package for beginners'
            ],
            [
                'type' => 'Package2',
                'number_of_lessons' => 20,
                'price_per_lesson' => 42.50,
                'isactive' => true,
                'remark' => 'Intermediate package with theory materials'
            ],
            [
                'type' => 'Package3',
                'number_of_lessons' => 30,
                'price_per_lesson' => 40.00,
                'isactive' => true,
                'remark' => 'Complete package including exam'
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}