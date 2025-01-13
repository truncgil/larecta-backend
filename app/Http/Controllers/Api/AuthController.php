<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Creates a new user registration.
     * 
     * @group Authentication
     * @subgroup Registration
     * 
     * @param Request $request Request object containing registration information
    * @bodyParam name string required User's full name. Maximum: 255 characters.
    * @bodyParam email string required User's email address. Maximum: 255 characters, must be unique.
    * @bodyParam password string required User's password. Minimum: 6 characters.
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception Possible errors during registration process
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'data' => $user,
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Authenticates user and creates token.
     * 
     * @group Authentication
     * @subgroup Login
     * 
     * @param Request $request Request object containing login credentials
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ], 401);
        }

        $user = Auth::user(); // Kullanıcıyı Auth ile alıyoruz
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'data' => $user,
            'token' => $token
        ], 200);
    }

    /**
     * Logs out the user and deletes all tokens.
     * 
     * @group Authentication
     * @subgroup Logout
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = Auth::user(); // Kullanıcıyı Auth ile alıyoruz
        $user->tokens()->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Logout successful'
        ], 200);
    }

   
    /**
     * Get user information.
     * 
     * @group Authentication
     * @subgroup User Profile
     * @authenticated
     * 
     * @response 200 {
     *   "status": true,
     *   "message": "User information retrieved successfully",
     *   "data": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "john@example.com",
     *     "email_verified_at": "2024-01-15T10:00:00.000000Z",
     *     "created_at": "2024-01-15T10:00:00.000000Z",
     *     "updated_at": "2024-01-15T10:00:00.000000Z"
     *   }
     * }
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        $user = Auth::user();
        
        return response()->json([
            'status' => true,
            'message' => 'User information retrieved successfully',
            'data' => $user
        ], 200);
    }

    /**
     * Updates user profile information.
     * 
     * @group Authentication
     * @subgroup User Profile
     * 
     * @param Request $request Request object containing profile update information
     * @authenticated
     * @return \Illuminate\Http\JsonResponse
     * 
     * @bodyParam name string optional Kullanıcının tam adı. Maximum: 255 karakter.
     * @bodyParam email string optional Kullanıcının email adresi. Maximum: 255 karakter, benzersiz olmalı.
     * @bodyParam password string optional Yeni şifre. Minimum: 8 karakter.
     * @bodyParam password_confirmation string optional Şifre onayı. password ile eşleşmeli.
     * 
     * @response 200 {
     *   "status": true,
     *   "message": "Profile updated successfully",
     *   "data": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "john@example.com",
     *     "updated_at": "2024-01-15T10:00:00.000000Z"
     *   }
     * }
     * 
     * @response 422 {
     *   "status": false,
     *   "message": "Validation error",
     *   "errors": {
     *     "email": ["The email has already been taken."],
     *     "password": ["The password confirmation does not match."]
     *   }
     * }
     * 
     * @throws \Exception Possible errors during profile update process
     */
    public function updateProfile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . auth()->id(),
                'password' => 'sometimes|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = auth()->user();
            $updateData = $request->only(['name', 'email']);
            
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }
            
            $user->update($updateData);
            
            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully',
                'data' => $user
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 