<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // function of registration
    public function register(Request $request) {
        // Field validation
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'is_admin' => 'boolean'
        ]);

        // Determine if the user is an admin
        $isAdmin = $request->input('is_admin', false);
        
        // user data creation
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'is_admin' => $isAdmin
        ]);

        // token creation
        $token = $user->createToken('myapptoken')->plainTextToken;

        // JSON Response
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    // function for logging in
    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid username or password.'
            ], 401);
        }

        // Determine if the user is an admin
         $isAdmin = $user->is_admin;

        // login token creation
        $token = $user->createToken('myapptoken')->plainTextToken;

        // JSON response
        $response = [
            'user' => $user,
            'token' => $token,
            'is_admin' => $isAdmin
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
