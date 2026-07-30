<?php

namespace App\Http\Resources\RentalUnit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalUnitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
    */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
