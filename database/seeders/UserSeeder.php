<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@superadmin.com',
            'unit_id' => 1,
            'password' => bcrypt('superadmin'),
            'email_verified_at' => date('Y-m-d H:i'),
        ]);
        $superadmin->assignRole('superadmin');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'unit_id' => 1,
            'password' => bcrypt('admin'),
            'email_verified_at' => date('Y-m-d H:i'),
        ]);
        $admin->assignRole('admin');

        $operator = User::create([
            'name' => 'Operator',
            'unit_id' => 2,
            'email' => 'operator@operator.com',
            'password' => bcrypt('operator'),
            'email_verified_at' => date('Y-m-d H:i'),
        ]);
        $operator->assignRole('operator');
    }
}
