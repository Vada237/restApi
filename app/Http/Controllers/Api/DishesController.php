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
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        if (auth()->user()->role_id == 1) {
        return DishesResource::collection(Dishes::paginate(5));
        }
        return response("Недостаточно прав", 403);
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
     * @return \Illuminate\Http\Response
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
     * Display the specified resource.
     *
     * @param  \App\Models\Dishes $dish
     * @return DishesResource
     */
    public function show(Dishes $dish)
    {
        if (auth()->user()->role_id == 1) {
        return new DishesResource($dish);
        }
        return response('Недостаточно прав', 403);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dishes  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit(dishes $dishes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dishes  $dish
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dishes  $dish
     * @return \Illuminate\Http\Response
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
