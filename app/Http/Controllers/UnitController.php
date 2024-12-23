<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unit\UnitIndexRequest;
use App\Http\Requests\Unit\UnitStoreRequest;
use App\Models\Bod;
use App\Models\DetailDepartment;
use App\Models\FunctionDepartment;
use App\Models\Unit;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Throwable;

class UnitController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:create unit', only: [
                'create',
                'store'
            ]),
            new Middleware('permission:read unit', only: ['show']),
            new Middleware('permission:update unit', only: [
                'edit',
                'update'
            ]),
            new Middleware('permission:delete unit', only: [
                'index',
                'delete',
                'deleteBulk'
            ]),

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(UnitIndexRequest $request)
    {
        $Units = DetailDepartment::query();
        if ($request->has('search')) {
            $Units->where('name', 'LIKE', "%".$request->search."%");
            $Units->orWhere('code', 'LIKE', "%".$request->search."%");
        }
        if ($request->has([
            'field',
            'order'
        ])) {
            $Units->orderBy($request->field, $request->order);
        }
        $perPage = $request->has('perPage') ? $request->perPage : 10;

        $listFuncDep = FunctionDepartment::get();
        $listBod = Bod::get();
        $listUnit = Unit::get();
        $listParent = DetailDepartment::get();

        return Inertia::render('Unit/Index', [
            'filters'     => $request->all([
                'search',
                'field',
                'order'
            ]),
            'perPage'     => (int) $perPage,
            'units'       => $Units->with([
                'bod',
                'functiondep',
                'parentdep',
                'unit'
            ])
                ->paginate($perPage),
            'listFuncDep' => $listFuncDep,
            'listBod'     => $listBod,
            'listUnit'    => $listUnit,
            'listParent'  => $listParent
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $unit = DetailDepartment::create([
                'title'           => $request->name,
                'functiondep_id'  => $request->funcdep['id'],
                'unit_id'         => $request->unit['id'],
                'kode_organisasi' => $request->code,
                'bod_id'          => $request->bod['id'],
                'parent_id'       => $request->parent ? $request->parent['id'] : null,
            ]);

            DB::commit();
            return back()->with('success', __('app.label.created_successfully', ['name' => $unit->title]));
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
    public function update(UnitStoreRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $unit = DetailDepartment::findOrFail($id);
            $unit->update([
                'title'           => $request->name,
                'functiondep_id'  => $request->funcdep['id'],
                'unit_id'         => $request->unit['id'],
                'kode_organisasi' => $request->code,
                'bod_id'          => $request->bod['id'],
                'parent_id'       => $request->parent ? $request->parent['id'] : null,
            ]);
            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $unit->title]));
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $unit->name]).$th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}