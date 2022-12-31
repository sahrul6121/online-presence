<?php

namespace App\Http\Controllers;

use App\Http\Requests\OnLeaveRecord\CreateOnLeaveRecordRequest;
use App\Http\Requests\OnLeaveRecord\UpdateOnLeaveRecordRequest;
use App\Http\Resources\OnLeaveRecordResource;
use App\Models\OnLeaveRecord;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OnLeaveRecordController extends Controller
{
   public function index(Request $request)
   {
      $query = OnLeaveRecord::query();

      if (Auth::user()->role->code !== 'HRD') {
         $query->where('user_id', $request->user_id);
      }

      return OnLeaveRecordResource::collection(
         $query->paginate($request->perPage ?? 10)
      );
   }

   public function store(CreateOnLeaveRecordRequest $request): JsonResource
   {
      $item = new OnLeaveRecord();

      $item->fill([
         ...$request->validated(),
         'user_id' => Auth::user()->id,
      ]);

      $item->save();

      return new OnLeaveRecordResource($item);
   }

   public function destroy($id)
   {
      $item = OnLeaveRecord::query()->findOrFail($id);
      $item->delete();

      return response()->json([
         'message' => 'Delete Success',
      ]);
   }

   public function show(int $id): JsonResource
   {
      $item = OnLeaveRecord::query()->findOrFail($id);

      return new OnLeaveRecordResource($item);
   }

   public function update(int $id, UpdateOnLeaveRecordRequest $request): JsonResource
   {
      $item = OnLeaveRecord::query()->findOrFail($id);

      $item->update($request->validated());

      return new OnLeaveRecordResource($item);
   }
}
