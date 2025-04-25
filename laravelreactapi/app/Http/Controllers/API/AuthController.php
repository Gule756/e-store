<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validation (fixed rule formatting)
        $validator = Validator::make($request->all(), [
            "name" => "required|max:191",
            "email" => "required|email|max:191|unique:users,email", // Removed spaces between rules
            "password" => "required|string|min:8|confirmed", // Removed spaces between rules
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 422, // More appropriate status for validation errors
                "validation_errors" => $validator->messages(),
            ]);
        }

        // 2. User creation
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        // 3. Token generation
        $token = $user->createToken($user->email . "_Token")->plainTextToken;

        // 4. Response
        return response()->json([
            "status" => 200,
            "username" => $user->name, // Use actual username
            "token" => $token, // Send real token
            "message" => "Registered Successfully"
        ]);
    }

    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        "email" => "required|email",
        "password" => "required|string|min:8",
    ]);

    if ($validator->fails()) {
        return response()->json([
            "status" => 422,
            "validation_errors" => $validator->messages(),
        ]);
    } else {
        $user = User::where("email", $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                // Check if the user is an admin (you need to define this)
                if ($user->role_as == 1) {
                    $token = $user->createToken($user->email . "_AdminToken", ['server:admin'])->plainTextToken;
                    $role = 'admin'; // You might want to include the role in the response
                } else {
                    $token = $user->createToken($user->email . "_Token", [''])->plainTextToken;
                    $role = ''; 
                }

                return response()->json([
                    "status" => 200,
                    "username" => $user->name,
                    "token" => $token,
                    "role" => $role, // Include the role in the response
                    "message" => "Login Successful"
                ]);
            } else {
                return response()->json([
                    "status" => 401,
                    "message" => "Invalid Password"
                ]);
            }
        } else {
            return response()->json([
                "status" => 404,
                "message" => "User not found"
            ]);
        }
    }
}

    public function logout(Request $request)
{
    try {
        Log::info('Logout attempt for user: ' . optional($request->user())->id);
        Log::debug('Request headers:', $request->headers->all());
        
        // Revoke all tokens for the user
        $request->user()->tokens()->delete();
        
        // If using session cookies (web middleware)
        // auth()->guard('web')->logout();
        
        return response()->json([
            "status" => 200,
            "message" => "Logged out successfully"
        ]);
        
    } catch (\Exception $e) {
        Log::error('Logout failed: ' . $e->getMessage());
        return response()->json([
            "status" => 500,
            "message" => "Logout failed"
        ], 500);
    }
}
}