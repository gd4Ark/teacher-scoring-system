<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\resetPasswordRequest;
use App\Http\Requests\Admin\UpdateRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        if ($user = Admin::query()->where('number', $request->get('number'))->first()) {
            if (password_verify($request->get('password'), $user['password'])) {
                $token = Auth::login($user);
                return $this->respondWithToken($token);
            }
        }
    }


    public function logout()
    {
        Auth::logout();
        return $this->message('成功登出');
    }


    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = Auth::user();
        if (!password_verify($request->get('password_current'), $user['password'])) {
            return $this->failed('Current password wrong');
        }
        $user['password'] = password_hash($request->get('password'), PASSWORD_DEFAULT);
        $user->save();
        return $this->message('reset success!');
    }


    public function resetNameNumber(UpdateRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $obj = Admin::query()->findOrFail($user->id);
        $obj->update($data);
        return $this->success('updated success!');
    }


    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    public function me()
    {
        return $this->success([
            'user' => Auth::user()
        ]);
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
