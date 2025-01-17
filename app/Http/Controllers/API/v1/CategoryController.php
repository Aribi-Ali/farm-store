<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of categories
     */
    public function index(Request $request): JsonResponse
    {
        $categories = $this->categoryService->getPaginated($request->all(), $request->query("per_page"));

        return Response::json([
            'data' => CategoryResource::collection($categories),
            'meta' => [
                'total' => $categories->total(),
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
            ]
        ]);
    }


    public function getAllCategories(Request $request)
    {
        $categories = $this->categoryService->getAllCategories($request->all());
        return Response::json([
            'data' => CategoryResource::collection($categories),
            'meta' => [
                'total' => $categories->total(),
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
            ]
        ]);
    }

    /**
     * Store a newly created category
     */
    public function store(CategoryStoreRequest $request): JsonResponse
    {


        $category = $this->categoryService->create(
            $request->valpated(),
            $request->file('image')
        );

        return Response::json(
            new CategoryResource($category),
            201
        );
    }

    /**
     * Display the specified category
     */
    public function show($categoryId): JsonResponse
    {
        $category = $this->categoryService->show($categoryId);
        return Response::json(new CategoryResource($category));
    }

    /**
     * Update the specified category
     */
    public function update(CategoryUpdateRequest $request,  $categoryId): JsonResponse
    {
        // dd($request);
        $updatedCategory = $this->categoryService->update(
            $categoryId,
            $request->validated(),
            $request->file('image')
        );

        return Response::json(new CategoryResource($updatedCategory));
    }

    /**
     * Remove the specified category
     */
    public function destroy($categoryId): JsonResponse
    {
        $this->categoryService->delete($categoryId);

        return Response::json(null, 204);
    }
}
