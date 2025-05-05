<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthApiService
{
    /**
     * Handle user registration.
     *
     * @param array $data
     * @return User
     */
    public function register(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Handle user login and token generation.
     *
     * @param array $credentials
     * @return array|null
     */
    public function login(array $credentials): array
    {
        /*
        // تحقق إذا كان المستخدم قد سجل دخوله بتوكين نشط
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->tokens->isNotEmpty()) {
            return [
                'status' => false,
                'message' => 'User already logged in with an active token',
                'code' => 400,
            ];
        }
            */


        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return [
                'status' => false,
                'message' => 'Email not found',
                'code' => 404,
            ];
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return [
                'status' => false,
                'message' => 'Incorrect password',
                'code' => 401,
            ];
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return [
            'status' => true,
            'user' => $user,
            'token' => $token,
            'code' => 200,
        ];
    }


    /**
     * Handle user logout (token revocation).
     *
     * @param User $user
     * @return void
     */
    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }
}
