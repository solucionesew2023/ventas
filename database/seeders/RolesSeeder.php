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
        $role1= Role::create(['name' => 'Administrador']);
        $role2= Role::create(['name' => 'Secretaria']);
        $role3= Role::create(['name' => 'Proveedor']);
        $role4= Role::create(['name' => 'Vendedor']);
        $role5= Role::create(['name' => 'Cliente']); 

        Permission::create(['name' => 'crearusuarios'])->syncRoles([$role1,$role2]);

    }
}
