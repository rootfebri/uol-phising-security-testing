<?php

namespace App\Http\Middleware;

use App\Models\Settings;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Allowance {
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('admin.*')) {
            return $next($request);
        }

        $visitor = Visitor::current();
        if ($visitor->isAllowed()) {
            return $next($request);
        }

        return response()->view('redirect', ['target' => Settings::me()->external_redirect]);
    }
}
