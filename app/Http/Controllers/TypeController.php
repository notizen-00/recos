<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Types;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Type\TypeIndexRequest;
use App\Http\Requests\Type\TypeStoreRequest;
class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

        public static function middleware(): array
    {
        return [
            new Middleware('permission:create type', only: ['create', 'store']),
            new Middleware('permission:read type', only: [ 'show']),
            new Middleware('permission:update type', only: ['edit', 'update']),
            new Middleware('permission:delete type', only: ['index', 'delete', 'deleteBulk']),
            
        ];
    }
    public function index(TypeIndexRequest $request)
    {
            $type = Types::query();
        if ($request->has('search')) {
            $type->where('name', 'LIKE', "%" . $request->search . "%");
        }
        if ($request->has(['field', 'order'])) {
            $type->orderBy($request->field, $request->order);
        }
        $perPage = $request->has('perPage') ? $request->perPage : 10;

        return Inertia::render('Type/Index', [
            'filters' => $request->all(['search', 'field', 'order']),
            'perPage' => (int) $perPage,
            'types' => $type->paginate($perPage),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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
        $type = Types::findOrFail($id);

        return Inertia::render('Type/Show', [
            'type' => $type->paginate($type),
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
        try {
            $type = Types::findOrFail($id);
            $type->delete();
            
               return back()->with('success', __('app.label.deleted_successfully', ['name' => $type->name]));
           } catch (\Throwable $th) {
               return back()->with('error', __('app.label.deleted_error', ['name' => $user->name]) . $th->getMessage());
           }
    }
}