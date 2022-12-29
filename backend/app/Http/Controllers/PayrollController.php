<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payroll\CreatePayrollRequest;
use App\Http\Requests\Payroll\UpdatePayrollRequest;
use App\Http\Resources\PayrollResource;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PayrollController extends Controller
{
   public function index(Request $request): JsonResource
   {
      $query = Payroll::query();

      if ($request->user_id) {
         $query->where('user_id', $request->user_id);
      }

      return PayrollResource::collection(
         Payroll::query()->paginate($request->perPage ?? 10)
      );
   }

   public function store(CreatePayrollRequest $request): JsonResource
   {
      $id = Payroll::query()->insertGetId($request->validated());

      return new PayrollResource($this->show($id));
   }

   public function destroy($id)
   {
      $item = Payroll::query()->findOrFail($id);
      $item->delete();

      return response()->json([
         'message' => 'Delete Success',
      ]);
   }

   public function show(int $id): JsonResource
   {
      $item = Payroll::query()->findOrFail($id);

      return new PayrollResource($item);
   }

   public function update(int $id, UpdatePayrollRequest $request): JsonResource
   {
      $item = Payroll::query()->findOrFail($id);

      $item->update($request->validated());

      return new PayrollResource($item);
   }
}
