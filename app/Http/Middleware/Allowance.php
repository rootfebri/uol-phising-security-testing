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
        $settings = Settings::me();
        if ($request->routeIs('admin.*')) {
            return $next($request);
        }

        if (!Visitor::current()->isAllowed() || $settings->isShouldRedirect()) {
            return response()->view('redirect', ['target' => $settings->external_redirect]);
        }

        return $next($request);
    }
}
