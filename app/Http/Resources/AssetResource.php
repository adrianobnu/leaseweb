<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => (int) $this->code,
            'price' => (float) $this->price,
            'brand' => new BrandResource($this->brand),
            'memories' => AssetMemoryResource::collection($this->memories),
            'disks' => AssetDiskResource::collection($this->disks),
        ];
    }
}
