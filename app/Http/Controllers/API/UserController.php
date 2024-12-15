<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function userDetail()
    {
        try {
            $user = Auth::user();
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'User details retrieved successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred while retrieving user details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $user = Auth::user()->load('role', 'userDetail', 'userAddress', 'userAddress.subDistrict', 'userAddress.subDistrict.district');
                $token = $user->createToken('authToken')->plainTextToken;

                return response()->json([
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Login successful',
                    'data' => [
                        'user' => $user,
                        'token' => 'Bearer ' . $token
                    ]
                ], 200);
            }

            return response()->json([
                'code' => 401,
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred during login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role_id' => 2
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'code' => 201,
                'status' => 'success',
                'message' => 'User registered successfully',
                'data' => [
                    'user' => $user,
                    'token' => 'Bearer ' . $token
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Failed to register user',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            ]);

            $user->update($validatedData);

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'User updated successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 400,
                'status' => 'error',
                'message' => 'Failed to update user',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Revoke the token that was used to authenticate the current request...
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Successfully logged out'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'An error occurred during logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
