<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Models\User;
use App\Services\StoreService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class StoreController extends Controller
{

    public function __construct(public StoreService $storeService) {}




    /**
     * Display a listing of categories
     */
    public function index(Request $request): JsonResponse
    {
        $stores = $this->storeService->getPaginated($request->all(), $request->query("per_page"));

        return Response::json([
            'data' => StoreResource::collection($stores),
            'meta' => [
                'total' => $stores->total(),
                'current_page' => $stores->currentPage(),
                'last_page' => $stores->lastPage(),
            ]
        ]);
    }


    public function store(StoreStoreRequest $request)
    {


        $store = $this->storeService->create($request->validated(), $request->file("logo"));
        return
            response()->json(new StoreResource($store), 201);
    }


    /**
     * Update the specified category
     */
    public function update(StoreUpdateRequest $request, $storeId): JsonResponse
    {
        // dd($request);
        $updatedStore = $this->storeService->update(
            $storeId,
            $request->validated(),
            $request->file('logo')
        );

        return Response::json(new StoreResource($updatedStore));
    }

    public function getStoreById($storeId)
    {
        return $this->storeService->getStoreById($storeId);
    }

    public function getStoreBySlug($storeId)
    {
        return $this->storeService->getStoreBySlug($storeId);
    }

    /**
     * Remove the specified category
     */
    public function destroy($storeId): JsonResponse
    {
        $this->storeService->delete($storeId);

        return Response::json(null, 204);
    }
}
