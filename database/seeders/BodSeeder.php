<?php

namespace Database\Seeders;

use App\Models\Bod;
use Illuminate\Database\Seeder;

class BodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__.'/bods.json'), true);
        foreach ($data as $item) {
            Bod::create($item);
        }
    }
}
