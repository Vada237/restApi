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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Orders::with(['orders_dishes']);
        return orderResource::collection($orders->paginate(10))->response();
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
     *
     * @return \Illuminate\Http\Response
     */

    public function store()
    {
        Orders::create([
            'status' => true
        ]);

        return response('Заказ создан', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\orders  $orders
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(orders $order)
    {
        return (new orderResource($order->loadMissing(['orders_dishes'])))->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $order = Orders::where('id',$request->id)->first();
        $order->status = false;
        $order->update();
        return response("Заказ обновлен", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\orders $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(orders $orders)
    {

    }
}
