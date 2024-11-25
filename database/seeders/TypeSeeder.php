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

        $surat_keputusan = SubTypes::create([
            'type_id' => $dinas_mengatur->id,
            'name' => 'Surat Keputusan',
            'letter_format' => 'Kpts',
        ]);

        $surat_perintah = SubTypes::create([
            'type_id' => $dinas_mengatur->id,
            'name' => 'Surat Perintah',
            'letter_format' => 'Prt',
        ]);

        $surat_edaran = SubTypes::create([
            'type_id' => $dinas_mengatur->id,
            'name' => 'Surat Edaran',
            'letter_format' => 'Edr',
        ]);

        $dinas_umum = Types::create([
            'name' => 'Surat Dinas Umum',
        ]);

        $memorandum = SubTypes::create([
            'type_id' => $dinas_umum->id,
            'name' => 'Memorandum',
            'letter_format' => 'Mem',
        ]);

        $nota = SubTypes::create([
            'type_id' => $dinas_umum->id,
            'name' => 'Nota',
            'letter_format' => 'Not',
        ]);

        $dinas_khusus = Types::create([
            'name' => 'Surat Dinas Khusus',
        ]);

        $surat_keterangan = SubTypes::create([
            'type_id' => $dinas_khusus->id,
            'name' => 'Surat Keterangan',
            'letter_format' => 'Ket',
        ]);

        $surat_perjanjian = SubTypes::create([
            'type_id' => $dinas_khusus->id,
            'name' => 'Surat Perjanjian',
            'letter_format' => 'Per',
        ]);

    }
}
