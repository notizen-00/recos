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
            'name'              => 'Superadmin',
            'email'             => 'superadmin@superadmin.com',
            'detail_department_id'=> 1,
            'password'          => bcrypt('superadmin'),
            'email_verified_at' => date('Y-m-d H:i'),
        ]);
        $superadmin->assignRole('superadmin');

        $admin = User::create([
            'name'              => 'Admin',
            'email'             => 'admin@admin.com',
            'detail_department_id'=> 1,
            'password'          => bcrypt('admin'),
            'email_verified_at' => date('Y-m-d H:i'),
        ]);
        $admin->assignRole('admin');

        $operator = User::create([
            'name'              => 'Corporate Secreate',
            'detail_department_id'=> 2,
            'email'             => 'operator@operator.com',
            'password'          => bcrypt('operator'),
            'email_verified_at' => date('Y-m-d H:i'),
        ]);
        $operator->assignRole('operator');
    }
}