<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthApiService;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    protected $authService;

    public function __construct(AuthApiService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle user registration.
     */
    public function register(CreateUserRequest $request)
    {
        $user = $this->authService->register($request->validated());

        return $this->registerResponse($user);
    }

    /**
     * Handle user login and return token.
     */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();


        $result = $this->authService->login($credentials);
    
        if (!$result['status']) {
            return $this->errorResponse($result['message'], null, $result['code']);
        }
    
        return $this->loginResponse(new UserResource($result['user']), $result['token']);
    }

    /**
     * Handle user logout and revoke tokens.
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->logoutResponse();
    }

    /**
     * Handel User information
     */

     public function user (Request $request) {
        return $this->successResponse("User get successfully",new UserResource($request->user()));
     }
}
