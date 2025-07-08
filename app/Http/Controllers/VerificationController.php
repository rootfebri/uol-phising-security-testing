<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerificationController extends Controller {
    public function card()
    {
        return Inertia::render('Account/VerifyCard');
    }

    public function cardPost(StoreCardRequest $request)
    {
        return back();
    }
}
