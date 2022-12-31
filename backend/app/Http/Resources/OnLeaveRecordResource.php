<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OnLeaveRecordResource extends JsonResource
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

         'title' => $this->title,

         'start' => $this->start,

         'end' => $this->end,

         'all_day' => $this->all_day,

         'extendedProps' => [

            'calender' => $this->calender,

            'description' => $this->description,
         ]
      ];
   }
}
