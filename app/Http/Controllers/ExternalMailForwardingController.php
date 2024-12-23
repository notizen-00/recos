<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExternalMailForwarding\ExternalMailForwardingShowRequest;
use App\Http\Requests\ExternalMailForwarding\ExternalMailForwardingStoreRequest;
use App\Models\ExternalMail;
use App\Models\ExternalMailDisposition;
use App\Models\FollowUpTypes;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExternalMailForwardingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ExternalMailForwardingShowRequest $request)
    {
        $externalMail = ExternalMail::query();
        $externalMail->where('forwarded_to_id', auth()->user()->id);

        $followUpTypes = FollowUpTypes::get();
        $userDepartment = User::with('detail_department.bod')
            ->get();

        if ($request->has('search')) {
            $externalMail->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->has([
            'field',
            'order'
        ])) {
            $externalMail->orderBy($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? (int) $request->perPage : 10;

        return Inertia::render('ExternalMailForwarding/Index', [
            'filters'        => $request->all([
                'search',
                'field',
                'order'
            ]),
            'perPage'        => (int) $perPage,
            'externalMail'   => $externalMail->paginate($perPage),
            'followUpTypes'  => $followUpTypes,
            'userDepartment' => $userDepartment,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExternalMailForwardingStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $recipients = $request->recipients;
            foreach ($recipients as $recipient) {
                $dataRecipient = explode(';', $recipient);
                $dataUnitRecipient = User::findOrFail($dataRecipient[0]);
                ExternalMailDisposition::create([
                    'external_mail_id'                     => $request->external_mail_id,
                    'recipient_user'                       => $dataRecipient[1],
                    'recipient_user_id'                    => $dataRecipient[0],
                    'recipient_user_detail_departments_id' => $dataUnitRecipient->detail_department_id,
                    'follow_up_type_id'                    => $request->follow_up_type['id'],
                    'follow_up_message'                    => $request->follow_up_message,
                ]);
            }

            ExternalMail::findOrFail($request->external_mail_id)
                ->update(['status' => '1']);
            DB::commit();
            return back()->with('success',
                __('app.label.created_successfully', ['name' => 'Disposisi Surat Masuk Eksternal']));
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error',
                __('app.label.created_error', ['name' => __('app.label.role')]).$th->getMessage().' '.$th->getLine());
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
