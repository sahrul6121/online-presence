<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $id = User::query()->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'message' => 'Success Register',
            'data' => new UserResource(User::query()->find($id)),
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            if (! $token = JWTAuth::attempt($request->validated())) {
                return response()->json([
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }

        return response()->json([
            'message' => 'Success Login',
            'data' => [
                'token' => $token,
                'user' => new UserResource(
                    User::query()
                        ->where('email', $request->get('email'))
                        ->first()
                )
            ],
        ]);
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        try {
            JWTAuth::invalidate($request->get('token'));

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
