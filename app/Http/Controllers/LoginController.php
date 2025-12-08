<?php

namespace App\Http\Controllers;

use App\Events\ActivityLogEvent;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class LoginController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
       $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            event(new ActivityLogEvent('Login'));
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function logout(Request $request): RedirectResponse
    {
        session()->flush();
        Auth::guard('web')->logout();
        return redirect(route('login'));
    }

    public function loginPage(): View
    {
        return view('auth.login');
    }
}
