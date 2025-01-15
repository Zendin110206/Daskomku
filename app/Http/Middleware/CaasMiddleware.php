<?php

namespace App\Http\Middleware;

use App\Models\CaasStage;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CaasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and not is_admin
        if (Auth::check() && !Auth::user()->is_admin) {
            // TODO: add if-else CaasStage user_id, stage_id, status (lolos/gagal)
            $user = Auth::user();
            $requestedRoute = $request->route()->getName();
            $caasStage = $user->caasStage()->first();
            
            // caas.shift, caas.gems
            if ($caasStage && in_array($requestedRoute, ['caas.shift', 'caas.gems'])) {
                if ($caasStage->status === 'Fail') {
                    // Redirect if the caas failed
                    return redirect()->route('caas.home');
                } else {
                    // Allow access if the caas passed
                    return $next($request);
                }
            }

            return $next($request); // Allow access
        }

        // Redirect to the login route if not authorized
        return redirect('/');
    }
}
