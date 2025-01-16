<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\badgeStoreRequest;
use App\Http\Requests\badgeUpdateRequest;
use App\Http\Resources\BadgeResource;
use App\Services\BadgeService;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class BadgeController extends Controller
{
    function __construct(public BadgeService $badgeService) {}

    public function index(Request $request)
    {
        $badges = $this->badgeService->getPaginated($request->all(), $request->query("per_page"));
        return Response::json([
            'data' => BadgeResource::collection($badges),
            'meta' => [
                'total' => $badges->total(),
                'current_page' => $badges->currentPage(),
                'last_page' => $badges->lastPage(),
            ]
        ]);
    }
    public function store(badgeStoreRequest $request)
    {

        $badge =  $this->badgeService->create($request->all(), $request->file("badgeFile"));
        return Response::json(
            new BadgeResource($badge),
            201
        );
    }
    public function update(badgeUpdateRequest $request, $badgeId)
    {

        $updatedBadge = $this->badgeService->update($badgeId, $request->validated(), $request->file("badgeFile"));
        return Response::json(new BadgeResource($updatedBadge));
    }
    public function show($badgeId)
    {

        $badge = $this->badgeService->show($badgeId);
        return Response::json(new BadgeResource($badge));
    }
    public function delete($badgeId)
    {

        $this->badgeService->delete($badgeId);
        return Response::json(null, 204);
    }
}
