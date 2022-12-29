<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {

        if ($request->pin_code != null) {
            $user = user::where('pin_code', $request->pin_code)->first();
            Auth::loginUsingId($user->id);
            $success['token'] = $user->createToken('Access token')->plainTextToken;
            $success['name'] = $user->name;
            $success['message'] = 'Авторизация прошла успешно';
            return response($success, 200);

        }

        if (Auth::attempt(['login' => $request->login, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Access token')->plainTextToken;
            $success['name'] = $user->name;
            $success['message'] = 'Авторизация прошла успешно';
            return response($success, 200);
        }

        return response('Ошибка авторизации', 400);
    }

    public function test() {
        dd(ctype_digit("55555"));
    }
}
