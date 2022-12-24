<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSheetActivity\CreateTimeSheetActivityRequest;
use App\Http\Requests\TimeSheetActivity\UpdateTimeSheetActivityRequest;
use App\Http\Resources\TimeSheetActivityResource;
use App\Models\TimeSheetActivity;
use Illuminate\Http\JsonResponse;
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
        return TimeSheetActivityResource::collection(
            TimeSheetActivity::query()->paginate($request->perPage ?? 10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateTimeSheetActivityRequest $request
     * @return JsonResponse
     */
    public function store(CreateTimeSheetActivityRequest $request)
    {
        $id = TimeSheetActivity::query()->insertGetId($request->validated());

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
    public function destroy($id)
    {
        $item = TimeSheetActivity::query()->findOrFail($id);

        $item->delete();

        return response()->json([
            'message' => 'Delete Success',
        ]);
    }
}
