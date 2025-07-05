<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LandingController extends Controller {
    public function index(Request $request)
    {
        $this->redirect_if($request, 'index');

        return view('locked');
    }

    public function post(): RedirectResponse
    {
        return $this->redirect_to(
            route: 'billing.index',
            method: 'index',
        );
    }

    public function finish(Request $request)
    {
        $this->redirect_if($request, 'finish');
        if (!Visitor::current()->is_finished) {
            return redirect()->route('login');
        }

        return view('finish');
    }
}
