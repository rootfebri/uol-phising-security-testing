<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $visitor = Visitor::current();

        return Inertia::render('Account/Restricted', ['email' => $visitor->user]);
    }
}
