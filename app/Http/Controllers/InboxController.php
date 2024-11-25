<?php

namespace App\Http\Controllers;

use App\Models\TrackingIncomingMail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        TrackingIncomingMail::query()->get();
        return Inertia::render(self::view('Index'), [
            'filters' => $request->all(['search', 'per_page']),
        ]);
    }

    private static function routeName($name):  string
    {
        return "inbox.$name";
    }
    private static function view($view): string
    {
        return "Inbox/$view";
    }


}
