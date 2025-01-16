<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagStoreRequest;
use App\Http\Resources\TagResource;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TagController extends Controller
{
    public function __construct(public TagService $tagService) {}


    public function index(Request $request)
    {
        $tags = $this->tagService->getPaginated($request->all(), $request->query("per_page"));
        return Response::json([
            "data" => TagResource::collection($tags),
            'meta' => [
                'total' => $tags->total(),
                'current_page' => $tags->currentPage(),
                'last_page' => $tags->lastPage(),
            ]
        ]);
    }
    public function create(TagStoreRequest $request)
    {

        $tag = $this->tagService->create($request->validated());
        return Response::json(new TagResource($tag), 201);
    }
    public function show($tagId)
    {
        $tag = $this->tagService->show($tagId);
        return Response::json(new TagResource($tag));
    }
    public function update(TagStoreRequest $request, $tagId)
    {
        $updatedTag = $this->tagService->update($request->validated(), $tagId);
        return Response::json(new TagResource($updatedTag));
    }
    public function delete($tagId)
    {

        $this->tagService->delete($tagId);
        return Response::json(null, 204);
    }
}
