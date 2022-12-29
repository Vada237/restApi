<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dishes_StructureRecource;
use App\Models\dishes_structures;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dishes_StructuresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            return Dishes_StructureRecource::collection(dishes_structures::paginate(10));
        } else return response('Недостаточно прав', 403);
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
    public function store(Request $request)
    {
        if (auth()->user()->role_id == 1) {
        $request->validate([
            'product_name' => ['required', 'max:30'],
            'dishes_id' => ['required'],
        ]);

        $dishesStructure = dishes_structures::create([
            "product_name" => $request->get("product_name"),
            "dishes_id" => $request->get("dishes_id")
        ]);

        return Response('created',200);
        } else Response('Недостаточно прав', 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\dishes_structures  $dishes_structure
     * @return Dishes_StructureRecource
     */
    public function show(dishes_structures $dishes_structure)
    {   if (auth()->user()->role_id == 1) {
            return new Dishes_StructureRecource($dishes_structure);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dishes_structures  $dishes_structure
     * @return \Illuminate\Http\Response
     */
    public function edit(dishes_structures $dishes_structure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\dishes_structures  $dishes_structure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, dishes_structures $dishes_structure)
    {
        if (auth()->user()->role_id == 1) {
            $dishes_structure->update($request->all());
            return response("updated", 200);
        }
        return response('Недостаточно прав', 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dishes_structures  $dishes_structure
     * @return \Illuminate\Http\Response
     */
    public function destroy(dishes_structures $dishes_structure)
    {
        if (auth()->user()->role_id == 1) {
            $dishes_structure->delete();
            return response("deleted", 200);
        }
        response('Недостаточно прав', 403);
    }
}
