<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\UserRegisteredMail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        $verificationPath = '/verify-email/' . $user->confirmation_token;
        $verificationUrl = $_ENV["VITE_API_BASE_URL"] . $verificationPath;

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

    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->email_verified_at === null) {
                return response()->json(['message' => 'Email not verified'], 401);
            }

            if ($user->is_admin === 0) {
                return response()->json(['message' => 'Not an admin user'], 401);
            }

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function passwordRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $token = Str::random(60);
        try {
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Erre az email címre már küldtünk egy linket.'], 409);    
        }
        
        $resetPath = '/password-reset/' . $token;
        $resetLink = $_ENV["VITE_API_BASE_URL"] . $resetPath;
        Mail::to($user->email)->send(new PasswordResetMail($user->name, $resetLink));

        return response()->json(['message' => 'A jelszóemlékeztető emailt kiküldtük a megadott email címre.']);
    }

    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|min:5',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$resetRecord) {
            return response()->json(['message' => 'Érvénytelen token. Kérjük igényelj egy másik jelszóváltoztató linket.'], 400);
        }

        $user = User::where('email', $resetRecord->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $resetRecord->email)->delete();

        return response()->json(['message' => 'A jelszó sikeresen megváltoztatva!']);
    }
}
