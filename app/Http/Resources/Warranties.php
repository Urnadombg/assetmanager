<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Warranties extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // tukl
        return [
            'asset_id' => $this->asset_id,
            'component_id' => $this->component_id,
            'card_id' => $this->card_id,
            'start' => Carbon::parse($this->start)->format('d.m.Y'),
            'end' => Carbon::parse($this->end)->format('d.m.Y'),
            'periodInDays' => ($this->periodInDays / 365),
            'isValid' => Carbon::now()->diffInMonths($this->end),
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
