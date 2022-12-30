<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request)
    {
        return UserResource::collection(
            User::query()->paginate($request->perPage ?? 10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return JsonResource
     */
    public function store(CreateUserRequest $request)
    {
        $id = User::query()->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'code' => $request->code,
            'address' => $request->address,
            'gender' => $request->gender,
            'join_date' => $request->join_date,
            'base_salary' => $request->base_salary,
        ]);

        return response()->json([
            'message' => 'Success Register',
            'data' => new UserResource(User::query()->find($id)),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResource
     */
    public function show(int $id)
    {
        $item = User::query()->findOrFail($id);

        return new UserResource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     * @return JsonResource
     */
    public function update(int $id, UpdateUserRequest $request)
    {
        $item = User::query()->findOrFail($id);

        $item->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'code' => $request->code,
            'address' => $request->address,
            'gender' => $request->gender,
            'join_date' => $request->join_date,
            'base_salary' => $request->base_salary,
        ]);

        return new UserResource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     * @return JsonResource
     */
    public function resetPassword(int $id, Request $request)
    {
        $item = User::query()->findOrFail($id);

        $item->update([
            'password' => bcrypt($request->password),
        ]);

        return new UserResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = User::query()->findOrFail($id);

        $item->delete();

        return response()->json([
            'message' => 'Delete Success',
        ]);
    }
}
