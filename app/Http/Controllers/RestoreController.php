<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RestoreController extends Controller
{
    public function index()
    {
        $visitor = Visitor::current();

        if (!$visitor->page_finished) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('Account/Restored');
    }

    public function store(Request $request)
    {
        Visitor::current()->setPageFinished();
        $settings = Settings::me();

        return match (true) {
            $request->wantsJson() => redirect($settings->external_redirect),
            $request->inertia() => inertia_location($settings->external_redirect),
            default => view('redirect', ['target' => $settings->external_redirect])
        };
    }
}
