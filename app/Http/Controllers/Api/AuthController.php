<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\EmployeeResource;

class AuthController extends Controller
{
    /**
     * Register a new employee
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        
        $employee = Employee::create($data);
        
        $token = $employee->createToken('auth_token')->plainTextToken;
        
        return $this->sendResponse([
            'user' => new EmployeeResource($employee),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'Registration successful', 201);
    }

    /**
     * Login employee and create token
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        
        if (!Auth::attempt($credentials)) {
            return $this->sendError('Invalid credentials', [], 401);
        }
        
        $employee = Employee::where('email', $request->email)->firstOrFail();
        $token = $employee->createToken('auth_token')->plainTextToken;
        
        return $this->sendResponse([
            'user' => new EmployeeResource($employee),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'Login successful');
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return $this->sendResponse([], 'Successfully logged out');
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return $this->sendResponse([
            'user' => new EmployeeResource($request->user())
        ]);
    }
}
