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

    public static function hasBilling(): string
    {
        return Cache::has(self::ck()) === true;
    }

    public function index()
    {
        if (self::hasBilling()) {
            return redirect()->route('card.index');
        }
        return Inertia::render('Billing/Index');
    }

    public static function ck(): string
    {
        return Visitor::current()->user . self::CK;
    }

    public function store(StoreBillingRequest $request): RedirectResponse
    {
        if (self::hasBilling()) {
            return redirect()->route('card.index');
        }

        Cache::put(self::ck(), new VisitorAddress($request));
        return redirect()->route('card.index');
    }
}
