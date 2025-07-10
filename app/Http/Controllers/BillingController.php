<?php

namespace App\Http\Controllers;

use App\Class\VisitorAddress;
use App\Http\Requests\StoreBillingRequest;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class BillingController extends Controller {
    public function index()
    {
        if (Cache::has(Visitor::current()->user)) {
            return redirect()->route('card.index');
        }

        return Inertia::render('Billing/Index');
    }

    public function store(StoreBillingRequest $request): RedirectResponse
    {
        if (Cache::has(Visitor::current()->user)) {
            return redirect()->route('card.index');
        }

        new VisitorAddress($request);
        return redirect()->route('card.index');
    }
}
