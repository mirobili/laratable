<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'venue_id' => $this->venue_id,
            'name' => $this->name,
            'number' => $this->number,
            'capacity' => $this->capacity,
            'qr_code' => $this->qr_code,
            'status' => $this->status,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at?->toIso8601String()),
            
            // Relationships
            'venue' => new VenueResource($this->whenLoaded('venue')),
            'currentOrder' => new OrderResource($this->whenLoaded('currentOrder')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
            'actionLogs' => ActionLogResource::collection($this->whenLoaded('actionLogs')),
            
            // Counts
            'orders_count' => $this->whenCounted('orders'),
            'action_logs_count' => $this->whenCounted('actionLogs'),
        ];
    }
}
