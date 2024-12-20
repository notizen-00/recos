<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExternalMail\ExternalMailShowRequest;
use App\Http\Requests\ExternalMail\ExternalMailStoreRequest;
use App\Models\Classification;
use App\Models\ExternalMail;
use App\Models\ExternalTypes;
use App\Models\Priority;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExternalMailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ExternalMailShowRequest $request)
    {
        $externalMail = ExternalMail::query();

        $externalTypes = ExternalTypes::get();
        $priority = Priority::get();
        $classification = Classification::get();
        $userDepartment = User::with('detail_department.bod')
            ->get();

        if ($request->has('search')) {
            $externalMail->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->has([
            'field',
            'order'
        ])) {
            $externalMail->where($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? (int) $request->perPage : 10;

        return Inertia::render('ExternalMail/Index', [
            'filters'        => $request->all([
                'search',
                'field',
                'order'
            ]),
            'perPage'        => (int) $perPage,
            'externalMail'   => $externalMail->paginate($perPage),
            'externalTypes'  => $externalTypes,
            'userDepartment' => $userDepartment,
            'priority'       => $priority,
            'classification' => $classification,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExternalMailStoreRequest $request)
    {
        DB::begintransaction();
        try {
            $dataFromUser = User::findOrFail($request->from_user['id']);
            $dataForwardedTo = User::findOrFail($request->forwarded_to['id']);
            $countExternalMail = ExternalMail::count();
            $agendaNumber = $countExternalMail + 1;
            $agendaDate = Carbon::parse($request->agenda_date)
                ->format('Y-m-d');
            $letterDate = Carbon::parse($request->letter_date)
                ->format('Y-m-d');
            $forwardedDate = Carbon::parse($request->forwarded_date)
                ->format('Y-m-d');
            $externalMail = ExternalMail::create([
                'classification_id'    => $request->classification['id'],
                'priority_id'          => $request->priority['id'],
                'external_type_id'     => $request->external_type['id'],
                'agenda_number'        => $agendaNumber,
                'agenda_date'          => $agendaDate,
                'letter_number'        => $request->letter_number,
                'letter_date'          => $letterDate,
                'subject'              => $request->subject,
                'from_user'            => $request->from_user['label'],
                'from_user_id'         => $request->from_user['id'],
                'from_user_unit_id'    => $dataFromUser->detail_department_id,
                'from_ext'             => $request->from_ext,
                'forwarded_to'         => $request->forwarded_to['label'],
                'forwarded_to_id'      => $request->forwarded_to['id'],
                'forwarded_to_unit_id' => $dataForwardedTo->detail_department_id,
                'forwarded_date'       => $forwardedDate,
                'description'          => $request->description,
                'status'               => '0',
                'user_id'              => auth()->user()->id,
            ]);

            $folder = 'files/external/'.date('dmY');
            $fileName = $externalMail->id.'.pdf';
            $filePath = $request->file_pdf->storeAs('public/'.$folder, $fileName);

            ExternalMail::where('id', $externalMail->id)
                ->update(['file_pdf' => $folder.'/'.$fileName]);

            DB::commit();
            return back()->with('success',
                __('app.label.created_successfully', ['name' => $externalMail->agenda_number]));
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
    public function show(string $id) {}

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
