<?php

namespace Database\Seeders;

use App\Models\FunctionDepartment;
use Illuminate\Database\Seeder;

class FunctionDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/function_departments.json'), true);
        foreach ($data as $item) {
            FunctionDepartment::create($item);
        }
    }
}
