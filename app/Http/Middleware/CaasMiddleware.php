<?php
// app/Http/Middleware/CaasMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CaasMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check user login
        if (Auth::check() && !Auth::user()->is_admin) {
            $user = Auth::user();
            $requestedRoute = $request->route()->getName();

            // Contoh: Jika user FAIL, larang akses route 'caas.shift', 'caas.gems'
            if ($user->caasStage && in_array($requestedRoute, ['caas.shift','caas.gems'])) {
                if ($user->caasStage->status === 'Fail') {
                    // Kembalikan ke home jika GAGAL
                    return redirect()->route('caas.home');
                }
            }

            // Lolos -> boleh akses
            return $next($request);
        }

        // Jika bukan CAAS atau belum login, arahkan ke login
        return redirect()->route('caas.login');
    }
}
