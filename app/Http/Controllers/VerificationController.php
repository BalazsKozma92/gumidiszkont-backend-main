<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request, $token)
    {
        $user = User::where('confirmation_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 400);
        }

        $user->email_verified_at = now();
        $user->save();

        return response()->json(['message' => 'Email verified successfully']);
    }
}
