<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\userRequest;
use App\Http\Resources\userResourse;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     operationId="usersAll",
     *     tags={"Users"},
     *     summary="Вывод всех пользователей",
     *     @OA\Response(
     *      response="200",
     *      description="Пользователи выведены"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */

    public function index()
    {
        if (auth()->user()->role_id == 1) {
        return userResourse::collection(user::paginate(10))->response();
        }
        return response('Недостаточно прав', 403);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     operationId="userCreate",
     *     tags={"Users"},
     *     summary="Создание пользователя",
     *     @OA\Response(
     *      response="200",
     *      description="Пользователь создан"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */

    public function store(Request $request)
    {
        if (auth()->user()->role_id == 1) {
            $request->validate([
                'name' => 'required',
                'login' => 'required|min:6',
                'password' => 'required|min:8',
                'pin_code' => 'required|integer|gte:10000|lte:99999',
                'role_id' => 'required'
            ]);

            $user = user::create([
                'name' => $request->name,
                'login' => $request->login,
                'password' => bcrypt($request->password),
                'pin_code' => $request->pin_code,
                'role_id' => $request->role_id
            ]);

            return response()->json([
                'status' => true,
                'message' => "Пользователь создан",
                'token' => $user->createToken('Access token')->plainTextToken
            ]);
        }
    }


    /**
     * @OA\Put(
     *     path="/api/users/{user_id}",
     *     operationId="userUpdate",
     *     tags={"Users"},
     *     summary="Изменение пользователя по id",
     *     @OA\Response(
     *      response="200",
     *      description="Пользователь изменен"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */

    public function update(userRequest $request, user $user)
    {
        if (auth()->user()->role_id == 1) {
            $user = user::where('id', $request->id)->first();
            $request->validate([
                'name' => 'required',
                'login' => 'required|min:6',
                'password' => 'required|min:8',
                'pin_code' => 'required|string|max:5|min:5',
                'role_id' => 'required'
            ]);

            $userData = [
                'name' => $request->name,
                'login' => $request->login,
                'password' => bcrypt($request->password),
                'pin_code' => $request->pin_code,
                'role_id' => $request->role_id
            ];
            $user->update($userData);
            return response('Пользователь обновлен', 200);
        }
        return response('Недостаточно прав', 403);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{user_id}",
     *     operationId="userDelete",
     *     tags={"Users"},
     *     summary="Удаление пользователя по id",
     *     @OA\Response(
     *      response="200",
     *      description="Пользователь удален"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */


    public function destroy(Request $request)
    {
        if (auth()->user()->role_id == 1) {
        $user = user::where('id', $request->id)->first();
        $user->delete();
        return response('Пользователь удален', 200);
        } return response('Недостаточно прав', 403);
    }

}
