<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'venue_id' => $this->venue_id,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at?->toIso8601String()),
            
            // Relationships
            'sections' => MenuSectionResource::collection($this->whenLoaded('sections')),
            'venue' => new VenueResource($this->whenLoaded('venue')),
            
            // Counts
            'sections_count' => $this->whenCounted('sections'),
        ];
    }
}
