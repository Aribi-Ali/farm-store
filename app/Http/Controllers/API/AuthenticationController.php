<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        $user = User::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('Personal Access Token')->accessToken;

            // send otp and redirect to verification page
                // can't navigate until the account is verified

        return response()->json([
            'user' => $user,
            'access_token' => $token
        ], 201);
    }

    /**
     * Authenticate user and generate token
     */
    public function login(Request $request)
    {
        // return $request;
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        }

        $user = $request->user();
        // return $user;
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token
        ]);
    }

    /**
     * Get authenticated user
     */
    public function getAuthenticatedUser(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Logout the user
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }




}
