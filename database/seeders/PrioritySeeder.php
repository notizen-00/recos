<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $segera = Priority::create([
            'name' => 'segera',
        ]);

        $biasa = Priority::create([
            'name' => 'biasa',
        ]);
    }
}
