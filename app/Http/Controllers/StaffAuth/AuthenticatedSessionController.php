<?php

namespace App\Http\Controllers\StaffAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\StaffAuth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function index()
    {
        return view('staff.auth.login',[
            'title'=>'e-Repo | Staff Login'
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'email'=> 'required',
            'password'=> 'required| min:8'
        ]);
        
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::STAFF_DASHBOARD);
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('staff')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('staff.login')->with('success','You has successfully logout !!');
    }
}
