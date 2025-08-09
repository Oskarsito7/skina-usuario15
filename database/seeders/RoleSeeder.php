<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'basic']);

        Permission::create(['name' => 'admin.dashboard', 'description' => 'Ver el panel de administración'])->assignRole($role1);
        Permission::create(['name' => 'admin.index', 'description' => 'Ver todas las tablas'])->assignRole($role1, $role2);
        Permission::create(['name' => 'admin.create', 'description' => 'Crear nuevos registros'])->assignRole($role1);
        Permission::create(['name' => 'admin.store', 'description' => 'Almacenar registros'])->assignRole($role1);
        Permission::create(['name' => 'admin.show', 'description' => 'Ver registros'])->assignRole($role1, $role2);
        Permission::create(['name' => 'admin.edit', 'description' => 'Editar registros'])->assignRole($role1);
        Permission::create(['name' => 'admin.update', 'description' => 'Actualizar registros'])->assignRole($role1);
        Permission::create(['name' => 'admin.destroy', 'description' => 'Eliminar registros'])->assignRole($role1);
    }
}
