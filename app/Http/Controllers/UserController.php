<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $users = User::all();
            return response()->json(['users' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Valami hiba történt'], 500);
        }
    }
}
