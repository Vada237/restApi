<?php

namespace App\Http\Resources;

use App\Models\orders_dishes;
use Illuminate\Http\Resources\Json\JsonResource;

class orderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $orders_dishes = order_dishesResource::collection($this->whenLoaded('orders_dishes'));
        return [
            'id' => $this->id,
            'create_date' => $this->created_at,
            'orders_dishes' => $orders_dishes,
            'count' => $orders_dishes->sum('count'),
            'sum' => $orders_dishes->sum('sum')
        ];

    }
}
