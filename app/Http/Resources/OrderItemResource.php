<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'menu_item_id' => $this->menu_item_id,
            'product_id' => $this->product_id,
            'quantity' => (int) $this->quantity,
            'unit_price' => (float) $this->unit_price,
            'total_price' => (float) $this->total_price,
            'status' => $this->status,
            'notes' => $this->notes,
            'prepared_by' => $this->prepared_by,
            'prepared_at' => $this->prepared_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at?->toIso8601String()),
            
            // Relationships
            'order' => new OrderResource($this->whenLoaded('order')),
            'menuItem' => new MenuItemResource($this->whenLoaded('menuItem')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'preparer' => new EmployeeResource($this->whenLoaded('preparer')),
            'actionLogs' => ActionLogResource::collection($this->whenLoaded('actionLogs')),
            
            // Computed
            'formatted_status' => $this->formatted_status,
            'is_prepared' => $this->is_prepared,
            'is_served' => $this->is_served,
            'is_cancelled' => $this->is_cancelled,
        ];
    }
}
