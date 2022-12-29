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
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        if (auth()->user()->role_id == 1) {
        return userResourse::collection(user::paginate(10))->response();
        }
        return response('Недостаточно прав', 403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
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
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
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
