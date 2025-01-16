<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class RoleController extends Controller
{
    function __construct(public RoleService $roleService) {}

    public function index(Request $request)
    {
        $roles = $this->roleService->getPaginated($request->all(), $request->query("per_page"));
        return Response::json([
            'data' => RoleResource::collection($roles),
            'meta' => [
                'total' => $roles->total(),
                'current_page' => $roles->currentPage(),
                'last_page' => $roles->lastPage(),
            ]
        ]);
    }
    public function store(RoleStoreRequest $request)
    {

        $role =  $this->roleService->create($request->all());
        return Response::json(
            new RoleResource($role),
            201
        );
    }
    public function update(RoleUpdateRequest $request, $roleId)
    {

        $updatedRole = $this->roleService->update($roleId, $request->validated());
        return Response::json(new RoleResource($updatedRole));
    }
    public function show($roleId)
    {

        $role = $this->roleService->show($roleId);
        return Response::json(new RoleResource($role));
    }
    public function delete($roleId)
    {

        $this->roleService->delete($roleId);
        return Response::json(null, 204);
    }

    // other function

    public function assignRole(Request $request,  $storeId)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $storeUserRole = $this->roleService->assignRole($validated, $storeId);
        return response()->json($storeUserRole);
    }
}
