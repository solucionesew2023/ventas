<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dep1= City::create(['name' => 'ABREDO',
                             'department_id' => '2'   
    ]);
    $dep1= City::create(['name' => 'bejorral',
    'department_id' => '1'   
]);

    }
}
