<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuSectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'menu_id' => $this->menu_id,
            'section_name' => $this->section_name,
            'description' => $this->description,
            'position' => $this->position,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at?->toIso8601String()),
            
            // Relationships
            'menu' => new MenuResource($this->whenLoaded('menu')),
            'items' => MenuItemResource::collection($this->whenLoaded('items')),
            
            // Counts
            'items_count' => $this->whenCounted('items'),
            'active_items_count' => $this->when(isset($this->active_items_count), $this->active_items_count),
        ];
    }
}
