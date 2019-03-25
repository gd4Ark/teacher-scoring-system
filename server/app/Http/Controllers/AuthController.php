<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @param \Illuminate\Http\Request;
     * @return \Illuminate\Http\JsonResponse;
     */
    public function login(Request $request)
    {
        try {
            if ($user = User::query()->where('username', $request->get('username'))->first()) {
                if (password_verify($request->get('password'), $user['password'])) {
                    $token = Auth::login($user);
                    return $this->respondWithToken($token);
                }
            }
            return $this->error('Incorrect Username or Password');

        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse;
     */
    public function logout()
    {
        Auth::logout();
        return $this->msg('Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}