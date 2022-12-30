<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\orderRequest;
use App\Http\Resources\orderResource;
use App\Models\orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    /**
     * @OA\Get(
     *     path="/api/orders",
     *     operationId="orderAll",
     *     tags={"Orders"},
     *     summary="Вывод всех заказов",
     *     @OA\Response(
     *      response="200",
     *      description="Заказы выведены"
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
        if (auth()->user()->role_id == 1) {
            $orders = Orders::with(['orders_dishes']);
            return orderResource::collection($orders->paginate(10))->response();
        }
        return response('Нет доступа', 403);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     operationId="orderCreate",
     *     tags={"Orders"},
     *     summary="Создает заказ",
     *     @OA\Response(
     *      response="200",
     *      description="Заказ создан"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     */

    public function store()
    {
        if (auth()->user()->role_id == 1) {
        Orders::create([
            'status' => true
        ]);
            return response('Заказ создан', 201);
        }
        return response('Пользователь не авторизован', 403);
    }

    /**
     * @OA\Get(
     *     path="/api/orders/{order_id}",
     *     operationId="orderGetById",
     *     tags={"Orders"},
     *     summary="Вывод заказа по id",
     *     @OA\Response(
     *      response="200",
     *      description="Заказ выведен"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\orders  $orders
     * @return \Illuminate\Http\JsonResponse
     */

    public function show(orders $order)
    {   if (auth()->user()->role_id == 1) {
            return (new orderResource($order->loadMissing(['orders_dishes'])))->response();
        }
    }

    /**
     * @OA\Put(
     *     path="/api/orders/close/{order_id}",
     *     operationId="orderUpdate",
     *     tags={"Orders"},
     *     summary="Закрывает заказ",
     *     @OA\Response(
     *      response="200",
     *      description="Заказ закрыт"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\orders  $orders
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        if (auth()->user()->role_id == 1) {
            $order = Orders::where('id', $request->id)->first();
            $order->status = false;
            $order->update();
            return response("Заказ обновлен", 200);
        }
        return response('Пользователь не авторизован', 403);
    }
}
