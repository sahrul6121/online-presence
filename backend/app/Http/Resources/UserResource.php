<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role' => new RoleResource($this->role),
            'code' => $this->code,
            'address' => $this->address,
            'gender' => $this->gender,
            'join_date' => $this->join_date,
            'base_salary' => $this->base_salary,
            'bank' => $this->bank,
            'bank_account' => $this->bank_account,
        ];
    }
}
