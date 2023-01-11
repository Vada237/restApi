<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DishesRequest;
use App\Http\Resources\DishesResource;
use App\Models\dishes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishesController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/dishes",
     *     operationId="dishesGetAll",
     *     tags={"Dishes"},
     *     summary="Вывод всех блюд",
     *     @OA\Response(
     *      response="200",
     *      description="Блюда выведены"
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
        return DishesResource::collection(Dishes::paginate(5));
        }
        return response("Недостаточно прав", 403);
    }

    /**
     * @OA\Post(
     *     path="/api/dishes",
     *     operationId="dishesCreate",
     *     tags={"Dishes"},
     *     summary="Создает блюдо",
     *     @OA\Response(
     *      response="200",
     *      description="Блюдо создано"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */

    public function store(DishesRequest $request)
    {
        if (auth()->user()->role_id == 1) {
            $request->validate([
                'name' => ['required', 'max:40'],
                'price' => ['required'],
                'caloric' => ['required'],
                'category_id' => ['required'],
                'image' => ['required', 'image', 'mimes:jpeg,bmp,png']
            ]);

            $dishes = dishes::create([
                "name" => $request->get("name"),
                "price" => $request->get("price"),
                "caloric" => $request->get("caloric"),
                "category_id" => $request->get("category_id"),
                "image" => $request->file('image')->store('public/dishes')
            ]);

            return Response('created', 200);
        }
        return response('Недостаточно прав');
    }

    /**
     * @OA\Get(
     *     path="/api/dishes/{dish_id}",
     *     operationId="dishesGetById",
     *     tags={"Dishes"},
     *     summary="Вывод блюда по id",
     *     @OA\Response(
     *      response="200",
     *      description="Блюдо выведено"
     *     ),
     *      @OA\Response(
     *      response="404",
     *      description="Блюдо не найдено"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */

    public function show(Dishes $dish)
    {
        if (auth()->user()->role_id == 1) {
        return new DishesResource($dish);
        }
        return response('Недостаточно прав', 403);
    }


    /**
     * @OA\Put(
     *     path="/api/dishes/{dishes_id}",
     *     operationId="dishesUpdate",
     *     tags={"Dishes"},
     *     summary="Обновляет блюдо по id",
     *     @OA\Response(
     *      response="200",
     *      description="Блюдо обновлено"
     *     ),
     *     @OA\Response(
     *      response="404",
     *      description="Блюдо не найдено"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */


    public function update(DishesRequest $request, Dishes $dish)
    {
        if (auth()->user()->role_id == 1) {
            if ($request->hasFile('image')) {
                Storage::delete("$dish->image");
                $imageName = $request->file('image')->store('public/dishes');
            } else {
                $imageName = $dish->image;
            }

            $dishesData = [
                'name' => $request->name,
                'price' => $request->price,
                'caloric' => $request->caloric,
                'category_id' => $request->category_id,
                'image' => $imageName
            ];

            $dish->update($dishesData);


            return Response('updated', 200);
        }
        return response('Недостаточно прав',403);
    }


    /**
     * @OA\Delete(
     *     path="/api/dishes/{dishes_id}",
     *     operationId="dishesDelete",
     *     tags={"Dishes"},
     *     summary="Удаляет блюдо по id",
     *     @OA\Response(
     *      response="200",
     *      description="Блюдо удалено"
     *     ),
     *     @OA\Response(
     *      response="404",
     *      description="Блюдо не найдено"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */

    public function destroy(Dishes $dish)
    {
        if (auth()->user()->role_id == 1) {
        Storage::delete("$dish->image");
        $dish->delete();
        return response("deleted",200);
        }
        return response('Недостаточно прав', 403);
    }
}
