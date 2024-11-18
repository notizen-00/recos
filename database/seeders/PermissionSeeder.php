<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'delete user', 'guard_name' => 'web']);
        Permission::create(['name' => 'update user', 'guard_name' => 'web']);
        Permission::create(['name' => 'read user', 'guard_name' => 'web']);
        Permission::create(['name' => 'create user', 'guard_name' => 'web']);

        Permission::create(['name' => 'delete unit', 'guard_name' => 'web']);
        Permission::create(['name' => 'update unit', 'guard_name' => 'web']);
        Permission::create(['name' => 'read unit', 'guard_name' => 'web']);
        Permission::create(['name' => 'create unit', 'guard_name' => 'web']);

        Permission::create(['name' => 'delete type', 'guard_name' => 'web']);
        Permission::create(['name' => 'update type', 'guard_name' => 'web']);
        Permission::create(['name' => 'read type', 'guard_name' => 'web']);
        Permission::create(['name' => 'create type', 'guard_name' => 'web']);

        Permission::create(['name' => 'delete role', 'guard_name' => 'web']);
        Permission::create(['name' => 'update role', 'guard_name' => 'web']);
        Permission::create(['name' => 'read role', 'guard_name' => 'web']);
        Permission::create(['name' => 'create role', 'guard_name' => 'web']);

        Permission::create(['name' => 'delete permission', 'guard_name' => 'web']);
        Permission::create(['name' => 'update permission', 'guard_name' => 'web']);
        Permission::create(['name' => 'read permission', 'guard_name' => 'web']);
        Permission::create(['name' => 'create permission', 'guard_name' => 'web']);
    }
}
