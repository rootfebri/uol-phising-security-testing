<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use Inertia\Inertia;

class VerificationController extends Controller {
    public function card(): \Inertia\Response
    {
        return Inertia::render('Account/VerifyCard');
    }

    public function cardPost(StoreCardRequest $request): ?\Illuminate\Http\RedirectResponse
    {
        return back();
    }
}
