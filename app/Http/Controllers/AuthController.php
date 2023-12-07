<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:12',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:5',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirmation_token' => strtoupper(Str::random(6)),
        ]);

        $frontendBaseUrl = 'http://localhost:8100';
        $verificationPath = '/verify-email/' . $user->confirmation_token;
        $verificationUrl = $frontendBaseUrl . $verificationPath;

        Mail::to($user->email)->send(new UserRegisteredMail($user->confirmation_token, $user->name, $verificationUrl));

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }



    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->email_verified_at === null) {
                return response()->json(['message' => 'Email not verified'], 401);
            }

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
