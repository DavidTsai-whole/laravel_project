<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(CreateUser $request)
    {
        // bcrypt 加密
        $validatedData = $request->validated();
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password'])
        ]);
        $user->save();
        return response('success', 201);
    }

    public function login(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        // Auth::attempt 登入
        if(!Auth::attempt($validateData)) {
            return response('登入失敗',401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Token');
        $tokenResult->token->save();
        return response(['token' => $tokenResult->accessToken]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response(
            ['message' => '成功登出']
        );
    }

    public function user(Request $request)
    {
        return response(
            $request->user()
        );
    }
}
