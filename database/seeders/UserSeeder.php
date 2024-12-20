<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 250; $i++) {
            $user_faker = User::create([
                'email'                => $faker->unique()->safeEmail,
                'name'                 => $faker->name,
                'detail_department_id' => $i,
                'password'             => bcrypt('recos123'),
            ]);
            $user_faker->assignRole('superadmin');
        }

        $superadmin = User::create([
            'name'                 => 'Superadmin',
            'email'                => 'superadmin@superadmin.com',
            'detail_department_id' => 1,
            'password'             => bcrypt('recos123'),
            'email_verified_at'    => date('Y-m-d H:i'),
        ]);
        $superadmin->assignRole('superadmin');

        $admin = User::create([
            'name'                 => 'Direktur',
            'email'                => 'direktur@direktur.com',
            'detail_department_id' => 1,
            'password'             => bcrypt('recos123'),
            'email_verified_at'    => date('Y-m-d H:i'),
        ]);
        $admin->assignRole('admin');

        $operator = User::create([
            'name'                 => 'Corporate Secreate',
            'detail_department_id' => 2,
            'email'                => 'operator@operator.com',
            'password'             => bcrypt('recos123'),
            'email_verified_at'    => date('Y-m-d H:i'),
        ]);
        $operator->assignRole('operator');
    }
}
