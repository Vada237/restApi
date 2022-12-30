<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\order_dishesResource;
use App\Models\dishes;
use App\Models\orders;
use App\Models\orders_dishes;
use Illuminate\Http\Request;

class Order_DishesController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/order_dishes",
     *     operationId="order_dishesGetAll",
     *     tags={"OrderDishes"},
     *     summary="Вывод всех блюд в заказе",
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        $orderDishes = orders_dishes::with(['dishes'])->get();
        return order_dishesResource::collection($orderDishes)->response();
    }

    /**
     * @OA\Post(
     *     path="/api/order_dishes",
     *     operationId="order_dishesCreate",
     *     tags={"OrderDishes"},
     *     summary="Добавляет блюдо в заказ",
     *     @OA\Response(
     *      response="200",
     *      description="Блюдо добавлено"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Пользователь не авторизован"
     *     )
     *)
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $order = Orders::where('id', $request->order_id)->first();

        if ($order->status) {

        $request->validate([
            'order_id' => 'required',
            'dishes_id' => 'required',
            'count' => 'required'
        ]);

        $dish = Dishes::where('id',"$request->dishes_id")->first();
            orders_dishes::create([
                'order_id' => $request->order_id,
                'dishes_id' => $request->dishes_id,
                'count' => $request->count,
                'sum' => $dish->price * (int)$request->count
            ]);
            return response('Блюдо добавлено в заказ', 200);
        } else return response('Невозможно добавить блюдо,так как заказ закрыт', 400);
    }

    /**
     * @OA\Delete(
     *     path="/api/dishes/{order_id}/{dishes_id}",
     *     operationId="order_dishesDelete",
     *     tags={"OrderDishes"},
     *     summary="Удаляет блюдо из заказа",
     *     @OA\Response(
     *      response="200",
     *      description="Блюдо удалено"
     *     ),
     *     @OA\Response(
     *      response="404",
     *      description="Блюдо или заказ не найден"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Пользователь не авторизован"
     *     )
     *)
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\orders_dishes  $orders_dishes
     * @return \Illuminate\Http\Response
     */

    public function destroy(orders_dishes $orders_dishes)
    {
        $orders_dishes->delete();
        return response('блюдо удалено из заказа');
    }
}
