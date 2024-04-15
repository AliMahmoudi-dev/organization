<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * reutrn login form.
     */
    public function create()
    {
        return view('login');
    }

    /**
     * User login.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        return redirect()->route('home');
    }

    /**
     * User logout.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
