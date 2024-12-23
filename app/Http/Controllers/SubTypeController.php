<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubType\SubTypeStoreRequest;
use App\Models\OutgoingMail;
use App\Models\SubTypes;
use DB;

class SubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubTypeStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $bod = array_column($request->bod, 'id');
            $subtype = SubTypes::create([
                'name'          => $request->name,
                'type_id'       => $request->type_id,
                'letter_format' => $request->letter_format,
                'form_type'     => $request->form_type,
                'ttd_type'      => $request->ttd_type,
                'bod'           => implode(',', $bod),
            ]);

            DB::commit();
            return back()->with('success', __('app.label.created_successfully', ['name' => $subtype->name]));
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error',
                __('app.label.created_error', ['name' => __('app.label.unit')]).$th->getMessage());
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
    public function update(SubTypeStoreRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $bod = array_column($request->bod, 'id');
            $subtype = SubTypes::findOrFail($id);
            $subtype->update([
                'name'          => $request->name,
                'type_id'       => $request->type_id,
                'letter_format' => $request->letter_format,
                'form_type'     => $request->form_type,
                'ttd_type'      => $request->ttd_type,
                'bod'           => implode(',', $bod),
            ]);
            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $subtype->name]));
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error',
                __('app.label.created_error', ['name' => __('app.label.unit')]).$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $nSub = OutgoingMail::where('sub_type_id', $id)
                ->count();
            if ($nSub == 0) {
                $subType = SubTypes::findOrFail($id);
                $subType->delete();
                DB::commit();
                return back()->with('success', __('app.label.deleted_successfully', ['name' => $subType->title]));
            } else {
                return back()->with('success', __('app.label.deleted_error', ['name' => $subType->title]));
            }
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $subType->title]).$th->getMessage());
        }
    }
}
