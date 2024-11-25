<?php

namespace Database\Seeders;

use App\Models\Classification;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $rahasia = Classification::create([
            'name' => 'Rahasia',
            'code' => 'Rah001',
            'description' => 'kode rahasia',
        ]);

        $penting = Classification::create([
            'name' => 'Penting',
            'code' => 'Pen001',
            'description' => 'Kode Penting',
        ]);
    }
}
