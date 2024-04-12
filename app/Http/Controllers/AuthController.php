<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(Request $request)
    {
        // Validate user input
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        // Create new user and save it to database
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        // Return success message with user data
        return ApiResponse::response(201, 'User created successfully!', $user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        //validating  user input
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //Check if user exists
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return ApiResponse::response(401, 'Email or password is incorrect');
        }

        //Create token for user
        $token = $user->createToken('auth_token')->plainTextToken;

        //Return response with user data and auth token
        return ApiResponse::response(200, "User logged In Successfully", [
            "user" => $user,
            "token" => $token
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::response(200, 'Logged out successfully');
    }
}
