<?php

namespace App\Http\Controllers\Mechanic\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MechanicLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController2 extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('mechanic.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(MechanicLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('mechanic.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('mechanic')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/mechanic/login');
    }
}
