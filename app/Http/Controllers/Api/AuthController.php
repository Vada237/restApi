<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     operationId="login",
     *     tags={"Authorization"},
     *     summary="Осуществляет вход пользователя по логину\паролю или пин-коду",
     *     @OA\Response(
     *      response="200",
     *      description="Произведен вход в систему"
     *     ),
     *      @OA\Response(
     *      response="400",
     *      description="Неверный логин\пароль или пин-код"
     *     )
     *)
     */

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
            if ($user = Auth::user()->role_id) {
                return response("Официанты входят только по пин-коду",400);
            }
            $success['token'] = $user->createToken('Access token')->plainTextToken;
            $success['name'] = $user->name;
            $success['message'] = 'Авторизация прошла успешно';
            return response($success, 200);
        }

        return response('Ошибка авторизации', 400);
    }
}
