<?php

namespace Database\Seeders;

use App\Models\ExternalTypes;
use Illuminate\Database\Seeder;

class ExternalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExternalTypes::create([
            'name' => 'Laporan',
        ]);
        ExternalTypes::create([
            'name' => 'Memorandum',
        ]);
        ExternalTypes::create([
            'name' => 'Surat',
        ]);
        ExternalTypes::create([
            'name' => 'Faximile',
        ]);
    }
}
