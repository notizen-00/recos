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
            'name' => 'Kepala UPATIK',
            'code' => 'TIK100',
            'level' => 1,
            'parent_id' => 0,
        ]
        );

        $Wakor = Unit::create([
            'name' => 'Wakor UPATIK',
            'code' => 'TIK200',
            'level' => 2,
            'parent_id' => $UPATIK->id,
        ]
        );

        $Jaringan = Unit::create([
            'name' => 'Jaringan',
            'code' => 'TIK301',
            'level' => 3,
            'parent_id' => $UPATIK->id,
        ]
        );

        $Programmer = Unit::create([
            'name' => 'Programmer',
            'code' => 'TIK302',
            'level' => 3,
            'parent_id' => $UPATIK->id,
        ]
        );

        $KantorPusat = Unit::create([
            'name' => 'Kantor Pusat',
            'code' => 'PUS100',
            'level' => 1,
            'parent_id' => 0,
        ]
        );

        $Kepegawaian = Unit::create([
            'name' => 'Kepegawaian',
            'code' => 'PUS200',
            'level' => 2,
            'parent_id' => $KantorPusat->id,
        ]
        );
    }
}
