<?php

namespace App\Http\Controllers;

use App\Models\User;
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        try {
            /**
             * @var $user User
             */
            $user = Auth::user();
            if (!password_verify($request->get('password_current'), $user['password'])) {
                throw new \Exception('Current password wrong');
            }
            if ($request->get('password') !== $request->get('password_confirm')) {
                throw new \Exception('Password & confirm are not equal');
            }
            $user['password'] = password_hash($request->get('password'), PASSWORD_DEFAULT);
            $user->save();
            return $this->msg('Reset Successfully');
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
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