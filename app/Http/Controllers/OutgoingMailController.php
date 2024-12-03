<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutgoingMail\OutgoingMailShowRequest;
use App\Http\Requests\OutgoingMail\OutgoingMailStoreRequest;
use App\Http\Requests\OutgoingMail\OutgoingMailVerifikasiRequest;
use App\Models\Classification;
use App\Models\OrgSubject;
use App\Models\OutgoingMail;
use App\Models\OutgoingRecipient;
use App\Models\Priority;
use App\Models\SubTypes;
use App\Models\TrackingOutgoingMail;
use App\Models\User;
use App\Services\OutgoingMailService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Throwable;

class OutgoingMailController extends Controller
{

    private function fetch_sign_by_bod(SubTypes $subType)
    {
        $bod_rule = $subType->bod;

        $sign_bod = User::with('detail_department')->whereIn('detail_department_id', $bod_rule)->get();
        return $sign_bod;
    }

    private function get_nomor_surat($sub_type_id)
    {
        $latest_mail = OutgoingMail::where('sub_type_id', $sub_type_id)
            ->orderBy('id', 'desc')
            ->first();

        if (!$latest_mail) {
            return 1;
        }

        return $latest_mail->no + 1;
    }

    private function generate_nomor_surat($sub_type_id, $kode = '')
    {
        $subtype = SubTypes::findOrFail($sub_type_id);

        $kode_surat = $subtype->letter_format;
        if ($kode == '') {
            return $kode_surat . '-' . $this->get_nomor_surat($sub_type_id) . '/RNM000000/' . date('Y') . '-SO';
        } else {
            if ($kode == 'get_kode') {
                return $kode_surat;
            } else {
                return '';
            }
        }

    }

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OutgoingMailStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $sub_type = SubTypes::findOrFail($request->sub_type_id);
            if ($sub_type->form_type == '1') {
                $outgoingMail = OutgoingMail::create([
                    'sub_type_id' => $request->sub_type_id,
                    'classification_id' => $request->classification['id'],
                    'priority_id' => $request->priority['id'],
                    'no' => $this->get_nomor_surat($request->sub_type_id),
                    'full_number' => $this->generate_nomor_surat($request->sub_type_id),
                    'subject' => $request->subject,
                    'code' => $this->generate_nomor_surat($request->sub_type_id, 'get_kode'),
                    'mail_place' => $request->mail_place,
                    'mail_date' => $request->mail_date,
                    'sign_user' => $request->sign_user['label'],
                    'user_id' => auth()->user()->id,
                ]);
            } else {
                $outgoingMail = OutgoingMail::create([
                    'sub_type_id' => $request->sub_type_id,
                    'classification_id' => $request->classification['id'],
                    'priority_id' => $request->priority['id'],
                    'no' => $this->get_nomor_surat($request->sub_type_id),
                    'full_number' => $this->generate_nomor_surat($request->sub_type_id),
                    'subject' => $request->subject,
                    'code' => $this->generate_nomor_surat($request->sub_type_id, 'get_kode'),
                    'mail_place' => '',
                    'mail_date' => $request->mail_date,
                    'sign_user' => $request->sign_user['label'],
                    'user_id' => auth()->user()->id,
                    'attachment' => $request->attachment,
                    'content' => $request->content,
                    'org_subject_id' => $request->org_subject_id['id'],
                ]);

                $fileName = $outgoingMail->id . '.pdf';
                $filePath = $request->attachment_file->storeAs('files/attachments/' . $request->sub_type_id, $fileName);

                OutgoingMail::where('id', $outgoingMail->id)
                    ->update(['attachment_file' => $filePath]);

                foreach ($request->recipients ?: [] as $recipient) {
                    $dataRecipient = User::findOrFail($recipient['id']);
                    OutgoingRecipient::create([
                        'outgoing_mail_id' => $outgoingMail->id,
                        'recipient_id' => $recipient['id'],
                        'recipient_unit_id' => $dataRecipient->unit_id,
                        'sender_id' => auth()->user()->id,
                        'recipient_type' => 'to',
                        'status' => '0',
                        'status_read' => '0',
                        'read_at' => DB::raw('NULL'),
                    ]);
                }

                foreach ($request->cc ?: [] as $cc) {
                    $dataCc = User::findOrFail($cc['id']);
                    OutgoingRecipient::create([
                        'outgoing_mail_id' => $outgoingMail->id,
                        'recipient_id' => $cc['id'],
                        'recipient_unit_id' => $dataCc->unit_id,
                        'sender_id' => auth()->user()->id,
                        'recipient_type' => 'cc',
                        'status' => '0',
                        'status_read' => '0',
                        'read_at' => DB::raw('NULL'),
                    ]);
                }
            }

            if ($outgoingMail) {
                TrackingOutgoingMail::create([
                    'outgoing_mail_id' => $outgoingMail->id,
                    'unit_id' => auth()->user()->unit_id,
                    'sender_id' => auth()->user()->id,
                    'to' => $request->to['id'],
                    'status' => 1,
                ]);
            }

            DB::commit();
            return back()->with('success',
                __('app.label.created_successfully', ['name' => $outgoingMail->full_number]));
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error',
                __('app.label.created_error', ['name' => __('app.label.role')]) . $th->getMessage() . ' ' . $th->getLine());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display a listing of the resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OutgoingMailShowRequest $request, OutgoingMailService $service, string $subTypeId)
    {

        dd($service);
        $outgoing = OutgoingMail::query();

        $outgoing->where('sub_type_id', $subTypeId);
        $outgoing->where('user_id', auth()->user()->id);

        $sub_type = SubTypes::findOrFail($subTypeId);

        $priority = Priority::get();
        $classification = Classification::get();
        $orgSubjects = OrgSubject::get();
        $detail_department = User::with('detail_department')
            ->get();

        $detail_department_sign = $this->fetch_sign_by_bod($sub_type);

        dd($detail_department_sign);
        if ($request->has('search')) {
            $outgoing->where('name', 'LIKE', "%" . $request->search . "%");
        }

        if ($request->has([
            'field',
            'order',
        ])) {
            $outgoing->orderBy($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('OutgoingMail/Show', [
            'filters' => $request->all([
                'search',
                'field',
                'order',
            ]),
            'perPage' => (int) $perPage,
            'outgoing_mail' => $outgoing->with('subTypes', 'trackingOutgoingMails.to.detail_department',
                'trackingOutgoingMails.sender.detail_department')
                ->paginate($perPage),
            'sub_type' => $sub_type,
            'detail_department' => $detail_department,
            'priority' => $priority,
            'classification' => $classification,
            'orgSubjects' => $orgSubjects,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function verifikasi(OutgoingMailVerifikasiRequest $request)
    {
        DB::beginTransaction();
        try {

            $latest = TrackingOutgoingMail::where('outgoing_mail_id', $request->outgoing_mail_id)
                ->latest()
                ->first();

            if ($latest) {
                $latest->update(['read_at' => Carbon::now()]);
            }
            TrackingOutgoingMail::create([
                'outgoing_mail_id' => $request->outgoing_mail_id,
                'detail_department_id' => auth()->user()->detail_department_pid,
                'sender_id' => auth()->user()->id,
                'to' => $request->to['id'],
                'status' => $request->status['value'],
                'note' => $request->note,
            ]);

            DB::commit();
            return back()->with('success', __('app.label.created_successfully', ['name' => 'Verifikasi']));
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error',
                __('app.label.created_error', ['name' => __('app.label.role')]) . $th->getMessage());
        }
    }
}
