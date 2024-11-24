<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutgoingMail\OutgoingMailShowRequest;
use App\Models\OutgoingMail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OutgoingMailController extends Controller
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
    public function show(OutgoingMailShowRequest $request, string $subTypeId)
    {
        $type = OutgoingMail::query();

        if ($request->has('search')) {
            $type->where('name', 'LIKE', "%" . $request->search . "%");
        }
        if ($request->has(['field', 'order'])) {
            $type->orderBy($request->field, $request->order);
        }
        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('OutgoingMail/Show', [
            'filters' => $request->all(['search', 'field', 'order']),
            'perPage' => (int) $perPage,
            'types' => $type->with('subTypes')->paginate($perPage),

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
