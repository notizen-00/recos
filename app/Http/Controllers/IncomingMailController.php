<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomingMail\IncomingMailShowRequest;
use App\Models\Classification;
use App\Models\OutgoingMail;
use App\Models\Priority;
use App\Models\SubTypes;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IncomingMailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingMailShowRequest $request, string $subTypeId)
    {
        $outgoing = OutgoingMail::query();

        $outgoing = OutgoingMail::query()
            ->where('sub_type_id', $subTypeId)
            ->whereHas('trackingOutgoingMails', function ($query) {
                $query->where('to', auth()->user()->id);
            })
            ->with(['trackingOutgoingMails' => function ($query) {
                $query->where('to', auth()->user()->id);
            }]);

        $sub_type = SubTypes::findOrFail($subTypeId);
        $priority = Priority::get();
        $classification = Classification::get();
        $unit = User::with('unit')->get();
        if ($request->has('search')) {
            $outgoing->where('name', 'LIKE', "%" . $request->search . "%");
        }

        if ($request->has(['field', 'order'])) {
            $outgoing->orderBy($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('IncomingMail/Show', [
            'filters' => $request->all(['search', 'field', 'order']),
            'perPage' => (int) $perPage,
            'outgoing_mail' => $outgoing->with('subTypes', 'trackingOutgoingMails.to.unit', 'trackingOutgoingMails.sender.unit')->paginate($perPage),
            'sub_type' => $sub_type,
            'unit' => $unit,
            'priority' => $priority,
            'classification' => $classification,
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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