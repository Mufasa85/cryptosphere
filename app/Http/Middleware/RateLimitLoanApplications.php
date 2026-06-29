<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitLoanApplications
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'loan-application:' . optional($request->user())->id ?: $request->ip();

        if (RateLimiter::tooManyAttempts($key, 15)) {
            return redirect()->back()->withErrors([
                'limit' => 'Trop de demandes de crédit. Veuillez réessayer dans 24 heures.',
            ]);
        }

        RateLimiter::hit($key, 60 * 60 * 24);

        return $next($request);
    }
}
