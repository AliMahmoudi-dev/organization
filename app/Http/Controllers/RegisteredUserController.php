<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * return register form to create user.
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Create a new user.
     */
    public function store(RegistrationRequest $request)
    {
        $inputs = $request->validated();

        $user = User::create([
            'name' => $inputs['name'],
            'national_code' => $inputs['national_code'],
            'phone_number' => $inputs['phone_number'],
            'email' => $inputs['email'],
            'password' => $inputs['password'],
        ]);

        Auth::login($user, true);

        return redirect()->route('home');
    }
}
