<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Inertia\Inertia;
use Illuminate\Validation\Rules;

// Models
use App\Models\User;

class RegisterController extends Controller
{
    public function create()
    {
        if (!Auth::user())
            return Inertia::render('Auth/Register');
        else
            return redirect(RouteServiceProvider::HOME);
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required','string','max:255'],
            'email'     => ['required','email','max:255','unique:users'],
            'password'  => ['required','confirmed','min:4', Rules\Password::defaults()],
            'password_confirmation' => ['required']
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
