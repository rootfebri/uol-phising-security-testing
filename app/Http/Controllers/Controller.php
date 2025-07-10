<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SensitiveParameter;
use Throwable;

abstract class Controller {
    public function back2base()
    {
        return redirect()->route('login.index');
    }
}
