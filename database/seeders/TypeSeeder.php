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
            'type_id'       => $dinas_mengatur->id,
            'name'          => 'Surat Keputusan',
            'letter_format' => 'Kpts',
            'form_type'     => '1'
        ]);

        $surat_perintah = SubTypes::create([
            'type_id'       => $dinas_mengatur->id,
            'name'          => 'Surat Perintah',
            'letter_format' => 'Prt',
            'form_type'     => '1'
        ]);

        $surat_edaran = SubTypes::create([
            'type_id'       => $dinas_mengatur->id,
            'name'          => 'Surat Edaran',
            'letter_format' => 'Edr',
            'form_type'     => '1'
        ]);

        $dinas_umum = Types::create([
            'name' => 'Surat Dinas Umum',
        ]);

        $memorandum = SubTypes::create([
            'type_id'       => $dinas_umum->id,
            'name'          => 'Memorandum',
            'letter_format' => 'Mem',
            'form_type'     => '2',
            'bod'           => '999,1,2,3'
        ]);

        $nota = SubTypes::create([
            'type_id'       => $dinas_umum->id,
            'name'          => 'Nota',
            'letter_format' => 'Not',
            'form_type'     => '2',
            'bod'           => '999,1,2,3,4,5,6'
        ]);

        $dinas_khusus = Types::create([
            'name' => 'Surat Dinas Khusus',
        ]);

        $surat_keterangan = SubTypes::create([
            'type_id'       => $dinas_khusus->id,
            'name'          => 'Surat Keterangan',
            'letter_format' => 'Ket',
            'form_type'     => '1'
        ]);


        $surat_perjanjian = SubTypes::create([
            'type_id'       => $dinas_khusus->id,
            'name'          => 'Surat Perjanjian',
            'letter_format' => 'Per',
            'form_type'     => '1'
        ]);

    }
}
