<?php

namespace Database\Seeders;

use App\Models\FollowUpTypes;
use Illuminate\Database\Seeder;

class FollowUpTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FollowUpTypes::create([
            'name' => 'Action',
        ]);
        FollowUpTypes::create([
            'name' => 'Tanggapan',
        ]);
        FollowUpTypes::create([
            'name' => 'Info',
        ]);
        FollowUpTypes::create([
            'name' => 'File',
        ]);
    }
}
