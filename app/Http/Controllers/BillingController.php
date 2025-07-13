<?php

namespace App\Http\Controllers;

use App\Class\VisitorAddress;
use App\Http\Requests\StoreBillingRequest;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class BillingController extends Controller {
    private const CK = 'billing_address';

    private function hasBilling(): string
    {
        return Cache::has($this->ck()) === true;
    }

    public function index()
    {
        if ($this->hasBilling()) {
            return redirect()->route('card.index');
        }
        return Inertia::render('Billing/Index');
    }

    private function ck(): string
    {
        return Visitor::current()->user . self::CK;
    }

    public function store(StoreBillingRequest $request): RedirectResponse
    {
        if ($this->hasBilling()) {
            return redirect()->route('card.index');
        }

        $visitorAddress = new VisitorAddress($request);
        Cache::put($this->ck(), $visitorAddress);
        return redirect()->route('card.index');
    }
}
