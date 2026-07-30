<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserViewResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request) {

        if(!Auth::attempt($request->validated())) {
            return response()->json([
                'message' => 'Account not found.'
            ]);
        }
        
        return new UserViewResource(Auth::user());
    }

    public function register(RegisterRequest $request) {

        $newUserCredentials = User::create($request->validated());

        return [
            'data' => $newUserCredentials,
            'message' => 'Created new user.'
        ];
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logout successfully.']);
    }

    public function getUser(Request $request) {
        return new UserViewResource($request->user());
    }

    public function checkAuthenticated() {

    }
}
