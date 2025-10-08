<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'product_type' => $this->product_type,
            'image_url' => $this->image_url,
            'is_active' => $this->is_active,
            'allergens' => $this->allergens ?? [],
            'preparation_time' => $this->preparation_time,
            'category' => $this->category,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at?->toIso8601String()),
            
            // Relationships
            'menuItems' => MenuItemResource::collection($this->whenLoaded('menuItems')),
            'orderItems' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            
            // Counts
            'menu_items_count' => $this->whenCounted('menuItems'),
            'order_items_count' => $this->whenCounted('orderItems'),
        ];
    }
}
