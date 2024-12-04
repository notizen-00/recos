<?php

namespace App\Http\Controllers;

use App\Models\IncomingMail;
use App\Models\OutgoingMail;
use Illuminate\Http\Request;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as Mpdf;

class ExportController extends Controller
{
    public function tte($mailModel, $mailId){
        if ($mailModel == 'outgoing') {
            $model = new OutgoingMail();
        } elseif ($mailModel == 'incoming') {
            $model = new IncomingMail();
        } else {
            abort(404);
        }

        $mail = $model::query()->whereKey($mailId)
            ->select('outgoing_mails.*', 'detail_departments.title as department_title'
                , 'users.name as user_name', 'sub_types.name as sub_type_name')
            //->whereRelation('subTypes', 'type_id', 2)
            ->join('users', 'users.id', '=', 'outgoing_mails.sign_user_id')
            ->join('detail_departments', 'detail_departments.id', '=', 'users.detail_department_id')
            ->join('sub_types', 'sub_types.id', '=', 'outgoing_mails.sub_type_id')
            ->where('sub_types.type_id', 2)
            ->firstOrFail();

        $pdf = Mpdf::loadView('export.tte', compact('mail'),[], [
            'title' => 'Ekspor Tanda Tangan Elektronik ',
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_left' => 0,
            'margin_right' => 0,
            'orientation' => 'P'
        ]);


        return $pdf->stream('ekspor_tte.pdf');
    }

    public function umum($outgoingMailId)
    {
        $mail = OutgoingMail::query()->whereKey($outgoingMailId)
            ->select('outgoing_mails.*', 'detail_departments.title as department_title'
                , 'users.name as user_name', 'sub_types.name as sub_type_name')
            //->whereRelation('subTypes', 'type_id', 2)
            ->join('users', 'users.id', '=', 'outgoing_mails.sign_user_id')
            ->join('detail_departments', 'detail_departments.id', '=', 'users.detail_department_id')
            ->join('sub_types', 'sub_types.id', '=', 'outgoing_mails.sub_type_id')
            ->where('sub_types.type_id', 2)
            ->with(['outgoingRecipients' => fn($query) =>
                $query->select('outgoing_recipients.id', 'outgoing_recipients.outgoing_mail_id'
                    , 'detail_departments.title')
                    ->where('recipient_type', 'to')
                    ->join('users', 'users.id', '=', 'outgoing_recipients.recipient_id')
                    ->join('detail_departments', 'detail_departments.id', '=', 'users.detail_department_id')
            ])
            ->firstOrFail();

        $data = compact('mail');
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
        return $pdf->stream('ekspor_surat_memorandum.pdf');
    }
}
