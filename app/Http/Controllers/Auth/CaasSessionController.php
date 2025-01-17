<?php
// app/Http/Contollers/Auth/CaasSessionController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaasSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function index()
    {
        return view('CaAs.LoginCaAs'); // Blade CAAS login
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Akan memanggil rules() + authenticate()
        
        $request->session()->regenerate();
        
        return redirect()->intended('/home'); // Setelah login -> /home
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('caas.login'));
    }
}
