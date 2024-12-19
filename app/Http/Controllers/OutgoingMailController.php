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

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OutgoingMailStoreRequest $request)
    {

        $service = new OutgoingMailService($request->sub_type_id);

        DB::beginTransaction();
        try {
            $sub_type = SubTypes::findOrFail($request->sub_type_id);
            if ($sub_type->form_type == '1') {
                $outgoingMail = OutgoingMail::create([
                    'sub_type_id' => $request->sub_type_id,
                    'classification_id' => $request->classification['id'],
                    'priority_id' => $request->priority['id'],
                    'subject' => $request->subject,
                    'code' => $service->generate_nomor_surat('get_kode'),
                    'mail_place' => $request->mail_place,
                    'mail_date' => $request->mail_date,
                    'sign_user' => $request->sign_user['label'],
                    'sign_user_id' => $request->sign_user['id'],
                    'user_id' => auth()->user()->id,
                ]);
            } else {
                $outgoingMail = OutgoingMail::create([
                    'sub_type_id' => $request->sub_type_id,
                    'classification_id' => $request->classification['id'],
                    'priority_id' => $request->priority['id'],
                    'subject' => $request->subject,
                    'code' => $service->generate_nomor_surat($request->sub_type_id, 'get_kode'),
                    'mail_place' => '',
                    'mail_date' => $request->mail_date,
                    'sign_user' => $request->sign_user['label'],
                    'sign_user_id' => $request->sign_user['id'],
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
                        'recipient_unit_id' => $dataRecipient->detail_department_id,
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
                        'recipient_unit_id' => $dataCc->detail_department_id,
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
                    'detail_department_id' => auth()->user()->detail_department->id,
                    'sender_id' => auth()->user()->id,
                    'to' => $request->to['id'],
                    'status' => 1,
                    'forward_date' => now(),
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

        $outgoing = OutgoingMail::query();
        $outgoing->where('sub_type_id', $subTypeId);
        $outgoing->where('user_id', auth()->user()->id);

        $sub_type = SubTypes::findOrFail($subTypeId);

        $priority = Priority::get();
        $classification = Classification::get();
        $orgSubjects = OrgSubject::get();
        $detail_department = User::with('detail_department')
            ->get();

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
                'trackingOutgoingMails.sender.detail_department', 'priority', 'classification', 'outgoingRecipients', 'outgoingRecipients.recipient.detail_department', 'orgSubject')
                ->paginate($perPage),
            'sub_type' => $sub_type,
            'detail_department' => $detail_department,
            'sign_mail_list' => $service->get_sign_letter_list(),
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

            $outgoing_mail = OutgoingMail::findOrFail($request->outgoing_mail_id);

            $shouldUpdate = false;

            if ($request->hasFile('attachment_file')) {
                $filePath = $request->file('attachment_file')->store('files', 'public');
                $outgoing_mail->attachment = $filePath;
                $shouldUpdate = true;
            }

            if ($request->filled('content')) {
                $outgoing_mail->content = $request->content;
                $shouldUpdate = true;
            }

            if ($request->filled('attachment')) {
                $outgoing_mail->attachment = $request->attachment;
                $shouldUpdate = true;
            }

            if ($shouldUpdate) {
                $outgoing_mail->save();
            }
            if (isset($request->is_confirm) === true) {

                $outgoing = OutgoingMail::findOrFail($request->outgoing_mail_id);

                $outgoing_service = new OutgoingMailService($outgoing->sub_type_id);

                $outgoing_service->update_nomor_surat($outgoing);

                TrackingOutgoingMail::create([

                    'outgoing_mail_id' => $request->outgoing_mail_id,
                    'detail_department_id' => auth()->user()->detail_department->id,
                    'sender_id' => auth()->user()->id,
                    'to' => $request->to['id'],
                    'status' => 2,
                    'note' => $request->note,
                    'forward_date' => now(),
                ]);
            } else {

                if ($request->status['value'] == 0) {
                    $outgoing = OutgoingMail::findOrFail($request->outgoing_mail_id);

                    TrackingOutgoingMail::create([
                        'outgoing_mail_id' => $request->outgoing_mail_id,
                        'detail_department_id' => auth()->user()->detail_department->id,
                        'sender_id' => auth()->user()->id,
                        'to' => $outgoing->user_id,
                        'status' => $request->status['value'],
                        'note' => $request->note,
                        'forward_date' => now(),

                    ]);
                } else if ($request->status['value'] == 1) {
                    TrackingOutgoingMail::create([
                        'outgoing_mail_id' => $request->outgoing_mail_id,
                        'detail_department_id' => auth()->user()->detail_department->id,
                        'sender_id' => auth()->user()->id,
                        'to' => $request->to['id'],
                        'status' => $request->status['value'],
                        'note' => $request->note,
                        'forward_date' => now(),
                    ]);
                }

            }

            DB::commit();
            return back()->with('success', __('app.label.created_successfully', ['name' => 'Verifikasi']));
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error',
                __('app.label.created_error', ['name' => __('app.label.role')]) . $th->getMessage());
        }
    }

    public function upload_foto(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file
        ]);

        try {
            // Menyimpan file ke direktori storage/foto_konten
            $filePath = $request->file('image')->store('foto_konten', 'public');

            // Mengembalikan path gambar yang dapat diakses oleh Quill Editor
            $imageUrl = asset('storage/' . $filePath);

            return response()->json([
                'success' => true,
                'url' => $imageUrl,
            ]);
        } catch (Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengunggah gambar: ' . $th->getMessage(),
            ], 500);
        }
    }

    public function view_attachment($id)
    {

        $outgoing_mail = OutgoingMail::findOrFail($id);

        $filename = $outgoing_mail->attachment_file;

        return Inertia::render('OutgoingMail/AttachmentView', [
            'filename' => $filename,
        ]);
    }

}
