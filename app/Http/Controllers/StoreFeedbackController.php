<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreFeedbackResource;
use App\Models\StoreFeedback;
use App\Services\StoreFeedbackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class StoreFeedbackController extends Controller
{

    public function __construct(public StoreFeedbackService $storeFeedbackService) {}


    public function store(Request $request, $storeId)
    {
        $storeFeedback = $this->storeFeedbackService->create($request->validated(), $storeId);
        return Response::json(
            new StoreFeedbackResource($storeFeedback),
            201
        );
    }
    public function show($storeFeedbackId)
    {

        $storeFeedback = $this->storeFeedbackService->show($storeFeedbackId);
        return Response::json(new StoreFeedbackResource($storeFeedback));
    }
    public function update(Request $request, $storeFeedbackId)
    {

        $updatedStoreFeedback = $this->storeFeedbackService->update($request->validated(), $storeFeedbackId);
        return Response::json(new StoreFeedbackResource($updatedStoreFeedback));
    }
    public function delete($storeFeedbackId)
    {

        $this->storeFeedbackService->delete($storeFeedbackId);
        return Response::json(null, 204);
    }
}
