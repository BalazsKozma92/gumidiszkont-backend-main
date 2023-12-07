<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductGroupResource;

class ProductListResource extends JsonResource
{
    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'product_group' => new ProductGroupResource($this->whenLoaded('productGroup')),
            'image_url' => $this->image ?: null,
            'price' => $this->price,
            'published' => (bool)$this->published,
            'sale_price' => $this->sale_price,
            'sale_active' => (bool)$this->sale_active,
            'title' => $this->title,
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}