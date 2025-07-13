<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $visitor = Visitor::current();

        return match ($visitor->user){
            true => redirect()->route('login.index'),
            false => Inertia::render('Account/Restricted', ['email' => $visitor->user]),
        };
    }
}
