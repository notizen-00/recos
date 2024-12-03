<?php

namespace Database\Seeders;

use App\Models\DetailDepartment;
use Illuminate\Database\Seeder;

class DetailDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/detail_departments.json'), true);
        foreach ($data as $item) {
            DetailDepartment::create($item);
        }
    }
}
