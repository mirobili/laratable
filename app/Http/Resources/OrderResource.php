<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'venue_id' => $this->venue_id,
            'table_id' => $this->table_id,
            'employee_id' => $this->employee_id,
            'order_number' => $this->order_number,
            'status' => $this->status,
            'total_amount' => (float) $this->total_amount,
            'tax_amount' => (float) $this->tax_amount,
            'discount_amount' => (float) $this->discount_amount,
            'notes' => $this->notes,
            'completed_at' => $this->completed_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at?->toIso8601String()),
            
            // Relationships
            'venue' => new VenueResource($this->whenLoaded('venue')),
            'table' => new TableResource($this->whenLoaded('table')),
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'actionLogs' => ActionLogResource::collection($this->whenLoaded('actionLogs')),
            'notifications' => NotificationResource::collection($this->whenLoaded('notifications')),
            
            // Counts
            'items_count' => $this->whenCounted('items'),
            'action_logs_count' => $this->whenCounted('actionLogs'),
            'notifications_count' => $this->whenCounted('notifications'),
            
            // Computed
            'subtotal' => (float) $this->subtotal,
            'formatted_status' => $this->formatted_status,
            'is_completed' => $this->is_completed,
            'is_cancelled' => $this->is_cancelled,
        ];
    }
}
