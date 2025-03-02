<?php

namespace App\Http\Controllers\Mechanic\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController2 extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('mechanic.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Mechanic::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'ContactNo' => ['nullable', 'string', 'max:11'],
            'Address' => ['nullable', 'string', 'max:255'],
        ]);

        $mechanic = Mechanic::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ContactNo' => $request->phone,
            'Address' => $request->address,
        ]);

        event(new Registered($mechanic));

        Auth::guard('mechanic')->login($mechanic);

        return redirect(route('mechanic.dashboard', absolute: false));
    }
}
