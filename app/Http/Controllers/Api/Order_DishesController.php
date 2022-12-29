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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

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
     * Display the specified resource.
     *
     * @param  \App\Models\orders_dishes  $orders_dishes
     * @return \Illuminate\Http\Response
     */
    public function show(orders_dishes $orders_dishes)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\orders_dishes  $orders_dishes
     * @return \Illuminate\Http\Response
     */
    public function edit(orders_dishes $orders_dishes)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\orders_dishes  $orders_dishes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, orders_dishes $orders_dishes)
    {
    }

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
