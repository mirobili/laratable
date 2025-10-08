<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VenueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'phone' => $this->phone,
            'contact_name' => $this->contact_name,
            'company_id' => $this->company_id,
            'meta_data' => $this->meta_data,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at?->toIso8601String()),
            
            // Relationships
            'company' => new CompanyResource($this->whenLoaded('company')),
            'tables' => TableResource::collection($this->whenLoaded('tables')),
            'menus' => MenuResource::collection($this->whenLoaded('menus')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
            
            // Counts
            'tables_count' => $this->whenCounted('tables'),
            'menus_count' => $this->whenCounted('menus'),
            'orders_count' => $this->whenCounted('orders'),
            'active_orders_count' => $this->when(isset($this->active_orders_count), $this->active_orders_count),
        ];
    }
}
