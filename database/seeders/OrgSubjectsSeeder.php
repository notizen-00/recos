<?php

namespace Database\Seeders;

use App\Models\OrgSubject;
use Illuminate\Database\Seeder;

class OrgSubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataOrgObjects = [
            [
                'id'   => '1',
                'name' => 'Umum',
                'code' => 'S0'
            ],
            [
                'id'   => '2',
                'name' => 'Medis',
                'code' => 'S1'
            ],
            [
                'id'   => '3',
                'name' => 'Penunjang Medis',
                'code' => 'S2'
            ],
            [
                'id'   => '4',
                'name' => 'Marketing',
                'code' => 'S3'
            ],
            [
                'id'   => '5',
                'name' => 'Keuangan',
                'code' => 'S4'
            ],
            [
                'id'   => '6',
                'name' => 'Teknik dan Pemeliharaan',
                'code' => 'S5'
            ],
            [
                'id'   => '7',
                'name' => 'Investasi',
                'code' => 'S6'
            ],
            [
                'id'   => '8',
                'name' => 'Pengadaan / Logistik',
                'code' => 'S7'
            ],
            [
                'id'   => '9',
                'name' => 'Kepegawaian / SDM',
                'code' => 'S8'
            ],
            [
                'id'   => '10',
                'name' => 'Teknologi Informasi',
                'code' => 'S9'
            ]
        ];

        foreach ($dataOrgObjects as $data) {
            OrgSubject::create([
                'id'   => $data['id'],
                'name' => $data['name'],
                'code' => $data['code']
            ]);
        }
    }
}
