<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BillingController extends Controller {
    public function index(Request $request)
    {
        $this->redirect_if($request, 'index');
        return view('billing');
    }

    public function store(StoreBillingRequest $request): RedirectResponse
    {
        $bill = self::encrypt($request->validated());
        return $this->redirect_to('payment.index', 'index', compact('bill'));
    }
}
