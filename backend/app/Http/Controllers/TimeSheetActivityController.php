<?php

namespace App\Http\Controllers;

use App\Enums\TimeSheetActivityStatus;
use App\Http\Requests\TimeSheetActivity\CreateTimeSheetActivityRequest;
use App\Http\Requests\TimeSheetActivity\UpdateTimeSheetActivityRequest;
use App\Http\Resources\TimeSheetActivityResource;
use App\Models\TimeSheetActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class TimeSheetActivityController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = TimeSheetActivity::query();

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        return TimeSheetActivityResource::collection(
            $query->paginate($request->perPage ?? 10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateTimeSheetActivityRequest $request
     * @return TimeSheetActivityResource
     */
    public function store(CreateTimeSheetActivityRequest $request)
    {
        $id = TimeSheetActivity::query()->insertGetId([
            ...$request->validated(),
            'user_id' => Auth::user()->id,
        ]);

        return new TimeSheetActivityResource($this->show($id));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResource
     */
    public function show(int $id): JsonResource
    {
        $item = TimeSheetActivity::query()->findOrFail($id);

        return new TimeSheetActivityResource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateTimeSheetActivityRequest $request
     * @return JsonResource
     */
    public function update(int $id, UpdateTimeSheetActivityRequest $request): JsonResource
    {
        $item = TimeSheetActivity::query()->findOrFail($id);

        $item->update($request->validated());

        return new TimeSheetActivityResource($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $item = TimeSheetActivity::query()->findOrFail($id);

        $item->delete();

        return response()->json([
            'message' => 'Delete Success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function approve(int $id)
    {
        $item = TimeSheetActivity::query()->findOrFail($id);

        $item->update([
            'status' => TimeSheetActivityStatus::APPROVED
        ]);

        return response()->json([
            'message' => 'Approve Success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function reject(int $id)
    {
        $item = TimeSheetActivity::query()->findOrFail($id);

        $item->update([
            'status' => TimeSheetActivityStatus::REJECTED
        ]);

        return response()->json([
            'message' => 'Reject Success',
        ]);
    }
}
