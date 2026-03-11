<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    /**
     * Hello method - returns a greeting message
     *
     * @param string $name
     * @return JsonResponse
     */
    public function hello(string $name): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => "Hello, {$name}!",
            'data' => [
                'greeting' => 'Hello',
                'name' => $name,
                'timestamp' => now()
            ]
        ]);
    }

    /**
     * Hi method - returns a casual greeting message
     *
     * @param string $name
     * @return JsonResponse
     */
    public function hi(string $name): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => "Hi there, {$name}!",
            'data' => [
                'greeting' => 'Hi',
                'name' => $name,
                'timestamp' => now()
            ]
        ]);
    }

    /**
     * High method - returns an enthusiastic greeting message
     *
     * @param string $name
     * @return JsonResponse
     */
    public function high(string $name): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => "Hey {$name}! What's up?",
            'data' => [
                'greeting' => 'High',
                'name' => $name,
                'timestamp' => now()
            ]
        ]);
    }
}
