<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization {
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed {
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        } else {
            app()->setLocale(auth()->user()->locale ?? 'uz');
            session()->put('locale', app()->getLocale());
        }

        return $next($request);
    }
}
