<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class InitializeVisitor {
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Admin routes use their own authentication and must never create or
        // update a visitor record for the administrator's browsing session.
        if ($request->routeIs('admin.*')) {
            return $next($request);
        }

        if (!Visitor::current()) {
            Visitor::lookup();
        }

        throw_if(Visitor::current() === null, new Exception('Visitor not found'));

        return $next($request);
    }
}
