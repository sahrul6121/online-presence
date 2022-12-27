<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkSchedule\CreateWorkScheduleRequest;
use App\Http\Requests\WorkSchedule\UpdateWorkScheduleRequest;
use App\Http\Resources\WorkScheduleResource;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkScheduleController extends Controller
{
   public function index(Request $request): JsonResource
   {
      return WorkScheduleResource::collection(
         WorkSchedule::query()->paginate($request->perPage ?? 10)
      );
   }

   public function store(CreateWorkScheduleRequest $request): JsonResource
   {
      $id = WorkSchedule::query()->insertGetId($request->validated());

      return new WorkScheduleResource($this->show($id));
   }

   public function destroy($id)
   {
      $item = WorkSchedule::query()->findOrFail($id);
      $item->delete();

      return response()->json([
         'message' => 'Delete Success',
      ]);
   }

   public function show(int $id): JsonResource
   {
      $item = WorkSchedule::query()->findOrFail($id);

      return new WorkScheduleResource($item);
   }

   public function update(int $id, UpdateWorkScheduleRequest $request): JsonResource
   {
      $item = WorkSchedule::query()->findOrFail($id);

      $item->update($request->validated());

      return new WorkScheduleResource($item);
   }
}
