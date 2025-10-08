<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'position' => $this->position,
            'hire_date' => $this->hire_date?->toDateString(),
            'is_active' => $this->is_active,
            'profile_image' => $this->profile_image,
            'last_login_at' => $this->last_login_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at?->toIso8601String()),
            
            // Relationships
            'company' => new CompanyResource($this->whenLoaded('company')),
            'venues' => VenueResource::collection($this->whenLoaded('venues')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
            'preparedItems' => OrderItemResource::collection($this->whenLoaded('preparedItems')),
            'actionLogs' => ActionLogResource::collection($this->whenLoaded('actionLogs')),
            'notifications' => NotificationResource::collection($this->whenLoaded('notifications')),
            
            // Counts
            'venues_count' => $this->whenCounted('venues'),
            'orders_count' => $this->whenCounted('orders'),
            'prepared_items_count' => $this->whenCounted('preparedItems'),
            'action_logs_count' => $this->whenCounted('actionLogs'),
            'notifications_count' => $this->whenCounted('notifications'),
            
            // Computed
            'full_name' => $this->full_name,
            'is_online' => $this->is_online,
            'role' => $this->when($this->relationLoaded('roles'), function() {
                return $this->roles->first()?->name;
            }),
            'permissions' => $this->when($this->relationLoaded('permissions'), function() {
                return $this->getAllPermissions()->pluck('name');
            }),
        ];
    }
}
