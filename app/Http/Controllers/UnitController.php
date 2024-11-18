<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unit\UnitIndexRequest;
use App\Http\Requests\Unit\UnitStoreRequest;
use App\Http\Requests\Unit\UnitUpdateRequest;
use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UnitController extends Controller implements HasMiddleware
{

      public static function middleware(): array
    {
        return [
            new Middleware('permission:create unit', only: ['create', 'store']),
            new Middleware('permission:read unit', only: [ 'show']),
            new Middleware('permission:update unit', only: ['edit', 'update']),
            new Middleware('permission:delete unit', only: ['index', 'delete', 'deleteBulk']),
            
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(UnitIndexRequest $request)
    {
        $Units = Unit::query();
        if ($request->has('search')) {
            $Units->where('name', 'LIKE', "%" . $request->search . "%");
            $Units->orWhere('code', 'LIKE', "%" . $request->search . "%");
        }
        if ($request->has(['field', 'order'])) {
            $Units->orderBy($request->field, $request->order);
        }
        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('Unit/Index', [
            'filters' => $request->all(['search', 'field', 'order']),
            'perPage' => (int) $perPage,
            'unitParents' => Unit::where('level',1)->get(),
            'units' => $Units->paginate($perPage),

        ]);
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
    public function store(UnitStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $unit = Unit::create([
                'name' => $request->name,
                'code' => $request->code,
                'level' => $request->level,
                'parent_id' => $request->parent_id,
            ]);
            
            DB::commit();
            return back()->with('success', __('app.label.created_successfully', ['name' => $unit->name]));
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
    public function update(UnitUpdateRequest $request, string $id)
    {
         DB::beginTransaction();
        try {
            $unit = Unit::findOrFail($id);
            $unit->update([
                'name'      => $request->name,
                'code'      => $request->code,
                'level'     => $request->level,
                'parent_id' => $request->parent_id,
            ]);
            DB::commit();
            return back()->with('success', __('app.label.updated_successfully', ['name' => $unit->name]));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('app.label.updated_error', ['name' => $unit->name]) . $th->getMessage());
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