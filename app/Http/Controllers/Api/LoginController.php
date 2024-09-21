<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        if($user->active == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Usuário inativo.'
            ], 403);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => true,
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Login ou senha incorreta.',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }
}
