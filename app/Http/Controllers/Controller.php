<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SensitiveParameter;
use Throwable;

abstract class Controller {
    public function back2login(): RedirectResponse
    {
        return redirect()->route('login.index');
    }

    public function back2dashboard(): RedirectResponse
    {
        return redirect()->route('dashboard');
    }
}
