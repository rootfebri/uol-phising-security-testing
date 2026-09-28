<?php

namespace App\Http\Controllers;

use App\Models\Visitor;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $visitor = Visitor::current();

        return view('account.restricted', ['email' => $visitor->user]);
    }
}
