<?php

namespace App\Http\Resources;

use App\Media;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'model' => $this->model,
            'serial' => $this->serial,
            'type_of_asset' => $this->type_of_asset,
            'deleted_at' => $this->deleted_at,
            'customer' => $this->customer->load('companies'),
            'location' => $this->location,
            'department' => $this->department,
            'purchaseDate' => $this->purchaseDate,
            'created_at' => Carbon::parse($this->created_at),
            'updated_at' => $this->updated_at,
            'components' => ComponentsResource::collection($this->whenLoaded('components')),
            'cc' => $this->countComponents(),
            'media' => $this->media,
            'warranty' => new Warranties($this->warranty),
            'maintenances' => $this->maintenances

        ];
    }
}
