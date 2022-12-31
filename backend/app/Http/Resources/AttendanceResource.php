<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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

            'date_in' => $this->date_in,

            'date_out' => $this->date_out,

            'note' => $this->note,

            'status' => $this->status,

            'type' => $this->type,
        ];
    }
}
