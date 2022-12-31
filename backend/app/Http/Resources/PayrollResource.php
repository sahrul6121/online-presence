<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayrollResource extends JsonResource
{
   /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
    */
   public function toArray($request)
   {
      return [
          'id' => $this->id,
          'user' => new UserResource($this->user),
          'date' => $this->date,
          'sub_total' => $this->sub_total,
          'tax' => $this->tax,
          'total' => $this->total,
          'company' => $this->company,
          'company_address' => $this->company_address,
          'company_phone' => $this->company_phone,
          'bank' => $this->bank,
          'bank_account' => $this->bank_account,
          'country' => $this->country,
          'items' => PayrollItemResource::collection($this->items),
      ];
   }
}
