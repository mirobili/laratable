<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'menu_section_id' => $this->menu_section_id,
            'product_id' => $this->product_id,
            'price' => (float) $this->price,
            'is_available' => $this->is_available,
            'position' => $this->position,
            'description_override' => $this->description_override,
            'image_url' => $this->image_url,
            'is_featured' => $this->is_featured,
            'is_vegetarian' => $this->is_vegetarian,
            'is_vegan' => $this->is_vegan,
            'is_gluten_free' => $this->is_gluten_free,
            'is_dairy_free' => $this->is_dairy_free,
            'is_nut_free' => $this->is_nut_free,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at?->toIso8601String()),
            
            // Relationships
            'section' => new MenuSectionResource($this->whenLoaded('section')),
            'product' => new ProductResource($this->whenLoaded('product')),
            
            // Computed
            'effective_description' => $this->description_override ?? $this->product?->description ?? null,
            'effective_image' => $this->image_url ?? $this->product?->image_url ?? null,
        ];
    }
}
