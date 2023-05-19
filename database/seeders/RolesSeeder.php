<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1= Role::create(['name' => 'admin']);
        $role2= Role::create(['name' => 'super-admin']);
        $role3= Role::create(['name' => 'secretaria']);
        $role4= Role::create(['name' => 'vendedor']);
        $role5= Role::create(['name' => 'proveedor']); 
        $role6= Role::create(['name' => 'cliente']);


    }
}
