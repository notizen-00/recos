<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(PermissionSeeder::class,

        );

        $this->call(RoleSeeder::class);

        $this->call(UnitSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ClassificationSeeder::class);
        $this->call(PrioritySeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(OrgSubjectsSeeder::class);
        $this->call(BodSeeder::class);
        $this->call(FunctionDepartmentSeeder::class);
        $this->call(DetailDepartmentSeeder::class);
    }
}
