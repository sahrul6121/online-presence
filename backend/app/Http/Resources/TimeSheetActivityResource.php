<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TimeSheetActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'start_time' => Carbon::now($this->start_time)->format('YYYY-MM-DD H:i:s'),
            'end_time' => Carbon::now($this->end_time)->format('YYYY-MM-DD H:i:s'),
        ];
    }
}
