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
        $stores = $this->storeService->getPaginated($request->all());

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


        $store = $this->storeService->create($request->all(), $request->file("logo"));
        return
            response()->json(new StoreResource($store), 201);
    }


    /**
     * Update the specified category
     */
    public function update(StoreUpdateRequest $request, $id): JsonResponse
    {
        // dd($request);
        $updatedStore = $this->storeService->update(
            $id,
            $request->validated(),
            $request->file('logo')
        );

        return Response::json(new StoreResource($updatedStore));
    }

    public function getStoreById($id)
    {
        return $this->storeService->getStoreById($id);
    }

    public function getStoreBySlug($id)
    {
        return $this->storeService->getStoreBySlug($id);
    }

    /**
     * Remove the specified category
     */
    public function destroy($id): JsonResponse
    {
        $this->storeService->delete($id);

        return Response::json(null, 204);
    }
}