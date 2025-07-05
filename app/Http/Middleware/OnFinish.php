<?php

namespace App\Http\Middleware;

use App\Models\Settings;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnFinish {
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // TODO: Check here
        $settings = Settings::me();

        if ($settings->redirect_on_finish && Visitor::current()->is_finished) {
            return redirect()->to($settings->external_redirect);
        }

        return $next($request);
    }
}
