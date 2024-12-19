<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExternalMail\ExternalMailShowRequest;
use App\Models\Classification;
use App\Models\ExternalMail;
use App\Models\ExternalTypes;
use App\Models\Priority;
use App\Models\User;
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
    public function show(string $id) {}

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
