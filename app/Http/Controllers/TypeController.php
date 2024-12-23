<?php

namespace App\Http\Controllers;

use App\Http\Requests\Type\TypeIndexRequest;
use App\Http\Requests\Type\TypeStoreRequest;
use App\Models\Bod;
use App\Models\SubTypes;
use App\Models\Types;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Throwable;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware(): array
    {
        return [
            new Middleware('permission:create type', only: [
                'create',
                'store'
            ]),
            new Middleware('permission:read type', only: ['show']),
            new Middleware('permission:update type', only: [
                'edit',
                'update'
            ]),
            new Middleware('permission:delete type', only: [
                'index',
                'delete',
                'deleteBulk'
            ]),

        ];
    }

    public function index(TypeIndexRequest $request)
    {
        $type = Types::query();

        if ($request->has('search')) {
            $type->where('name', 'LIKE', "%".$request->search."%");
        }
        if ($request->has([
            'field',
            'order'
        ])) {
            $type->orderBy($request->field, $request->order);
        }
        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('Type/Index', [
            'filters' => $request->all([
                'search',
                'field',
                'order'
            ]),
            'perPage' => (int) $perPage,
            'types'   => $type->with('subTypes')
                ->paginate($perPage),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TypeStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $type = Types::create([
                'name' => $request->name,
            ]);

            DB::commit();
            return back()->with('success', __('app.label.created_successfully', ['name' => $type->name]));
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error',
                __('app.label.created_error', ['name' => __('app.label.unit')]).$th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Display the specified resource.
     */
    public function show(TypeIndexRequest $request, string $id)
    {
        $type = Types::with('subTypes')
            ->findOrFail($id);
        $subType = SubTypes::query();
        $subType->where('type_id', $id);

        if ($request->has('search')) {
            $subType->where('name', 'LIKE', "%".$request->search."%");
        }

        if ($request->has([
            'field',
            'order'
        ])) {
            $subType->orderBy($request->field, $request->order);
        }

        $perPage = $request->has('perPage') ? $request->perPage : 10;
        $bod = Bod::get();

        return Inertia::render('Type/Show', [
            'filters'  => $request->all([
                'search',
                'field',
                'order'
            ]),
            'perPage'  => (int) $perPage,
            'subTypes' => $subType->paginate($perPage),
            'id'       => $id,
            'type'     => $type,
            'bod'      => $bod,
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
    public function update(TypeStoreRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $type = Types::findOrFail($id);
            $type->update([
                'name' => $request->name,
            ]);
            DB::commit();
            return back()->with('success', __('app.label.created_successfully', ['name' => $type->name]));
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
        try {
            $type = Types::findOrFail($id);
            $type->delete();

            return back()->with('success', __('app.label.deleted_successfully', ['name' => $type->name]));
        } catch (Throwable $th) {
            return back()->with('error', __('app.label.deleted_error').$th->getMessage());
        }
    }
}