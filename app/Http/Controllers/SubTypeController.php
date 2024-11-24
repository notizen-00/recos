<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubType\SubTypeStoreRequest;
use App\Models\SubTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
    public function store(SubTypeStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $subtype = SubTypes::create([
                'name' => $request->name,
                'type_id' => $request->type_id,
                'letter_format' => $request->letter_format,
            ]);

            DB::commit();
            return back()->with('success', __('app.label.created_successfully', ['name' => $subtype->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.created_error', ['name' => __('app.label.unit')]) . $th->getMessage());
        }
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
