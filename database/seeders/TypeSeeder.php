<?php

namespace Database\Seeders;

use App\Models\SubTypes;
use App\Models\Types;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dinas_mengatur = Types::create([
            'name' => 'Surat Dinas Mengatur',
        ]);

        $dinas_umum = Types::create([
            'name' => 'Surat Dinas Umum',
        ]);

        $dinas_khusus = Types::create([
            'name' => 'Surat Dinas Khusus',
        ]);

        $data = json_decode(file_get_contents(__DIR__.'/sub_types.json'), true);
        foreach ($data as $item) {
            SubTypes::create($item);
        }

    }
}
