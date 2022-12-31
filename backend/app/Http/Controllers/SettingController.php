<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setting\CreateSettingRequest;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingController extends Controller
{
   public function index(Request $request): JsonResource
   {
      return SettingResource::collection(
         Setting::query()->paginate($request->perPage ?? 10)
      );
   }

   public function store(CreateSettingRequest $request): JsonResource
   {
      $id = Setting::query()->insertGetId($request->validated());

      return new SettingResource($this->show($id));
   }

   public function destroy($id)
   {
      $item = Setting::query()->findOrFail($id);
      $item->delete();

      return response()->json([
         'message' => 'Delete Success',
      ]);
   }

   public function show(int $id): JsonResource
   {
      $item = Setting::query()->findOrFail($id);

      return new SettingResource($item);
   }

   public function update(int $id, UpdateSettingRequest $request): JsonResource
   {
      $item = Setting::query()->findOrFail($id);

      $item->update($request->validated());

      return new SettingResource($item);
   }
}
