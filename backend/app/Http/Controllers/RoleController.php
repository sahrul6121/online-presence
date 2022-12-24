<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\RoleCollection;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        return RoleResource::collection(
            Role::query()->paginate($request->perPage ?? 10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRoleRequest $request
     * @return JsonResource
     */
    public function store(CreateRoleRequest $request): JsonResource
    {
        $id = Role::query()->insertGetId($request->validated());

        return new RoleResource($this->show($id));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResource
     */
    public function show(int $id): JsonResource
    {
        $item = Role::query()->findOrFail($id);

        return new RoleResource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateRoleRequest $request
     * @return JsonResource
     */
    public function update(int $id, UpdateRoleRequest $request): JsonResource
    {
        $item = Role::query()->findOrFail($id);

        $item->update($request->validated());

        return new RoleResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = Role::query()->findOrFail($id);

        $item->delete();

        return response()->json([
            'message' => 'Delete Success',
        ]);
    }
}
