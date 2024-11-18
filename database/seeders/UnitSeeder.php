<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $UPATIK = Unit::create([
            'name' => 'UPATIK',
            'code' => 'TIK001',
            'level' => 1,
            'parent_id' => 0,
        ]
        );

        $Jaringan = Unit::create([
            'name' => 'Jaringan',
            'code' => 'TIK002',
            'level' => 2,
            'parent_id' => $UPATIK->id,
        ]
        );

        $Programmer = Unit::create([
            'name' => 'Programmer',
            'code' => 'TIK003',
            'level' => 2,
            'parent_id' => $UPATIK->id,
        ]
        );

        $KantorPusat = Unit::create([
            'name' => 'Kantor Pusat',
            'code' => 'PUS001',
            'level' => 1,
            'parent_id' => 0,
        ]
        );

        $Kepegawaian = Unit::create([
            'name' => 'Kepegawaian',
            'code' => 'PUS002',
            'level' => 2,
            'parent_id' => $KantorPusat->id,
        ]
        );
    }
}
