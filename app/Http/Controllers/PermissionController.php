<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Resources\permissionResource;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class PermissionController extends Controller
{
    function __construct(public PermissionService $permissionService) {}

    public function index(Request $request)
    {
        $permissions = $this->permissionService->getPaginated($request->all(), $request->query("per_page"));
        return Response::json([
            'data' => permissionResource::collection($permissions),
            'meta' => [
                'total' => $permissions->total(),
                'current_page' => $permissions->currentPage(),
                'last_page' => $permissions->lastPage(),
            ]
        ]);
    }
    public function store(RoleStoreRequest $request)
    {

        $permission =  $this->permissionService->create($request->all());
        return Response::json(
            new permissionResource($permission),
            201
        );
    }
    public function update(RoleUpdateRequest $request, $permissionId)
    {

        $updatedPermission = $this->permissionService->update($permissionId, $request->validated());
        return Response::json(new permissionResource($updatedPermission));
    }
    public function show($permissionId)
    {

        $permission = $this->permissionService->show($permissionId);
        return Response::json(new permissionResource($permission));
    }
    public function delete($permissionId)
    {

        $this->permissionService->delete($permissionId);
        return Response::json(null, 204);
    }



    // other


    public function assignPermission(Request $request,  $storeUserRoleId)
    {
        $validated = $request->validate([
            'permission_id' => 'required|exists:permissions,id',
        ]);

        $permission = $this->permissionService->assignPermission($validated, $storeUserRoleId);

        return response()->json($permission);
    }
}
