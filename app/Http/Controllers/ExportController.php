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
            $mail = OutgoingMail::query()->whereKey($mailId)
                ->select('outgoing_mails.id', 'outgoing_mails.full_number', 'outgoing_mails.subject'
                    ,'outgoing_mails.mail_date','outgoing_mails.sign_date'
                    , 'detail_departments.title as department_title'
                    , 'users.name as user_name', 'sub_types.name as sub_type_name')
                //->whereRelation('subTypes', 'type_id', 2)
                ->join('users', 'users.id', '=', 'outgoing_mails.sign_user_id')
                ->join('detail_departments', 'detail_departments.id', '=', 'users.detail_department_id')
                ->join('sub_types', 'sub_types.id', '=', 'outgoing_mails.sub_type_id')
                ->where('sub_types.type_id', 2)
                ->firstOrFail();
        } elseif ($mailModel == 'incoming') {
            $query = new IncomingMail();
        } else {
            abort(404);
        }



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

    public function show($mailModel, $mailId)
    {
        if ($mailModel == 'outgoing') {
            $mail = OutgoingMail::query()->whereKey($mailId)
                ->select('outgoing_mails.id', 'outgoing_mails.full_number', 'outgoing_mails.subject'
                    ,'outgoing_mails.mail_date','outgoing_mails.content','outgoing_mails.attachment','outgoing_mails.sign_date'
                    , 'detail_departments.title as department_title'
                    , 'users.name as user_name'
                    , 'sub_types.name as sub_type_name', 'sub_types.id as sub_type_id', 'sub_types.type_id as type_id')
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
        } elseif ($mailModel == 'incoming') {
            $model = new IncomingMail();
        } else {
            abort(404);
        }

        $data = compact('mail');
        $view = '';
        $title = '';
        $fileName = '';

        if ($mail->type_id == 2){
            $view = 'export.umum';
            $title = 'Ekspor Surat '. $mail->sub_type_name;
            $fileName = 'ekspor_surat_'. $mail->sub_type_name .'.pdf';
        }

        $pdf = Mpdf::loadView($view, $data,[], [
            'title' => $title,
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_top' => 32,
            'margin_bottom' => 37,
            'margin_left' => 0,
            'margin_right' => 0,
            'orientation' => 'P'
        ]);
        return $pdf->stream($fileName);

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
