<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'ni_number' => $this->ni_number,
            'email' => $this->when($request->input('detail'), $this->email),
            'phone' => $this->when($request->input('detail'), $this->phone),
            'date_of_birth' => $this->when($request->input('detail'), Carbon::parse($this->date_of_birth)->format('Y-m-d')),
            'SL1' => $this->when($request->input('detail'), $this->SL1),
            'SL2' => $this->when($request->input('detail'), $this->SL2),
            'SL4' => $this->when($request->input('detail'), $this->SL4),
            'SLPG' => $this->when($request->input('detail'), $this->SLPG),
        ];
    }
}
