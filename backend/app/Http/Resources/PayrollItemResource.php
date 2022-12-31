<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayrollItemResource extends JsonResource
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
            'payroll_id' => $this->payroll_id,
            'subject' => $this->subject,
            'description' => $this->description,
            'rate' => $this->rate,
            'day' => $this->day,
            'hours' => $this->hours,
            'total' => $this->total,
        ];
    }
}
