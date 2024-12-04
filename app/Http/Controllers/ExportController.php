<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as Mpdf;

class ExportController extends Controller
{
    public function tte(){
        $data = [
            'title' => 'aaa',
            'date' => now()->toDateTimeString(),
            'id' => 1,
            'perihal' => 'lorem ipsum',
            'senior_name' => 'aaa',
            'senior_position' => 'aaa',
            'signer_position' => 'aaa',
            'signer_name' => 'aaa',
        ];
        //return 1;

        $pdf = Mpdf::loadView('export.tte', $data,[], [
            'title' => 'Ekspor Tanda Tangan Elektronik ',
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
            'orientation' => 'P'
        ]);


        return $pdf->stream('document.pdf');
    }

    public function umum()
    {
        $data = [
            'title' => 'aaa',
            'date' => now()->toDateTimeString(),
            'id' => 1,
            'perihal' => 'lorem ipsum',
            'senior_name' => 'aaa',
            'senior_position' => 'aaa',
            'signer_position' => 'aaa',
            'signer_name' => 'aaa',
        ];
        $pdf = Mpdf::loadView('export.umum', $data,[], [
            'title' => 'Ekspor Surat Memorandum ',
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 32,
            'margin_bottom' => 37,
            'margin_left' => 0,
            'margin_right' => 0,
            'orientation' => 'P'
        ]);
        return $pdf->stream('document.pdf');
    }
}
