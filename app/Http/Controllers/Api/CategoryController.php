<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\FlareClient\Http\Response;
use function MongoDB\BSON\toJSON;

class CategoryController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/",
     *     summary="Возвращает список категорий",
     *     tags={"categories"},
     *     @SWG\Response(
     *         response=200,
     *         description="успешная операция",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Category")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Доступ запрещен",
     *     ),
     * )
     */
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            return CategoryResource::collection(Category::paginate(5));
        }
        return response('Недостаточно прав', 403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryRequest $request)
    {

    }

    /**
     * @SWG\Post(
     *     path="/",
     *     summary="Создает категорию",
     *     tags={"categories"},
     *     @SWG\Response(
     *         response=200,
     *         description="Категория создана",
     *         @SWG\Schema(
     *             type="category",
     *             @SWG\Items(ref="#/definitions/Category")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Доступ запрещен",
     *     ),
     * )
     */
    public function store(CategoryRequest $request)
    {
        if (auth()->user()->role_id == 1) {
            $request->validate([
                'name' => 'required', 'min:3',
                'image' => 'required','image','mimes:jpeg,bmp,png'
            ]);

            $category = Category::create([
                "name" => $request->get("name"),
                "image" => $request->file('image')->store('public/images')
            ]);

            return Response('created',200);
        }
        return response('Недостаточно прав', 403);
        }

    /**
     * @SWG\Get(
     *     path="/{id}",
     *     summary="Возвращает выбранную категорию",
     *     tags={"categories"},
     *     @SWG\Response(
     *         response=200,
     *         description="выведена категория",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Category")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Доступ запрещен",
     *     ),
     * )
     */
    public function show(Category $category)
    {
        if (auth()->user()->role_id == 1) {
            return new CategoryResource($category);
        }
        return response('Недостаточно прав', 403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * @SWG\Put(
     *     path="/{category}",
     *     summary="Обновляет категорию по id",
     *     tags={"categories"},
     *     @SWG\Response(
     *         response=200,
     *         description="Категория обновлена",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Category")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Доступ запрещен",
     *     ),
     * )
     */

    public function update(Request $request, Category $category)
    {
        if (auth()->user()->role_id == 1) {
            if ($request->hasFile('image')) {
                Storage::delete("$category->image");
                $imageName = $request->file('image')->store('public/images');
            } else {
                $imageName = $category->image;
            }

            $categoryData = [
                'name' => $request->name,
                'image' => $imageName
            ];

            $category->update($categoryData);


            return Response('updated', 200);
        }
        return Response('Недостаточно прав', 403);
    }

    /**
     * @SWG\Get(
     *     path="/{id}",
     *     summary="Удаление категории по id",
     *     tags={"categories"},
     *     @SWG\Response(
     *         response=200,
     *         description="Категория удалена",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/Category")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         description="Доступ запрещен",
     *     ),
     * )
     */

    public function destroy(Category $category)
    {
        if (auth()->user()->role_id == 1) {
        Storage::delete("$category->image");
        $category->delete();
        return response('deleted',200);
        }
        return response('Недостаточно прав', 403);
    }
}
