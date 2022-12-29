<?php

namespace App\Http\Resources;

use App\Models\dishes;
use Illuminate\Http\Resources\Json\JsonResource;

class order_dishesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $dish = $this->whenLoaded('dishes');
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'dish' => new DishesResource($dish),
            'count' => $this->count,
            'sum' => $this->sum
        ];
    }


}
