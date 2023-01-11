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
     * @OA\Get(
     *     path="/api/categories",
     *     operationId="categoriesAll",
     *     tags={"Categories"},
     *     summary="Выводит категории блюд",
     *     @OA\Response(
     *      response="200",
     *      description="Категории выведены"
     *     ),
     *     @OA\Response(
     *     response="404",
     *     description="Категории не найдены"
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    public function index()
    {
        if (auth()->user()->role_id == 1) {
            return CategoryResource::collection(Category::paginate(5));
        }
        return response('Недостаточно прав', 403);
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     operationId="categoriesCreate",
     *     tags={"Categories"},
     *     summary="Создает категорию",
     *     @OA\Response(
     *      response="200",
     *      description="Категория создана"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
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
     * @OA\Get(
     *     path="/api/categories/{category_id}",
     *     operationId="categoryGetById",
     *     tags={"Categories"},
     *     summary="Вывод категории по id",
     *     @OA\Response(
     *      response="200",
     *      description="Продукт выведен"
     *     ),
     *     @OA\Response(
     *      response="404",
     *      description="Продукт не найден"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
     */

    public function show(Category $category)
    {
        if (auth()->user()->role_id == 1) {
            return new CategoryResource($category);
        }
        return response('Недостаточно прав', 403);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{category_id}",
     *     operationId="categoriesUpdate",
     *     tags={"Categories"},
     *     summary="Обновляет категорию",
     *     @OA\Response(
     *      response="200",
     *      description="Категория обновлена"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
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
     * @OA\Delete(
     *     path="/api/categories/{category_id}",
     *     operationId="categoriesDelete",
     *     tags={"Categories"},
     *     summary="Удаляет категорию",
     *     @OA\Response(
     *      response="200",
     *      description="Категория удалена"
     *     ),
     *      @OA\Response(
     *      response="403",
     *      description="Нет доступа или пользователь не авторизован"
     *     )
     *)
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
