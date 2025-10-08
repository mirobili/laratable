<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->when($this->email_verified_at, function () {
                return $this->email_verified_at?->toIso8601String();
            }),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            
            // Relationships
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'notifications' => NotificationResource::collection($this->whenLoaded('notifications')),
            'read_notifications' => NotificationResource::collection($this->whenLoaded('readNotifications')),
            'unread_notifications' => NotificationResource::collection($this->whenLoaded('unreadNotifications')),
            
            // Counts
            'notifications_count' => $this->whenCounted('notifications'),
            'unread_notifications_count' => $this->when(isset($this->unread_notifications_count), $this->unread_notifications_count),
            
            // Computed
            'has_verified_email' => $this->hasVerifiedEmail(),
            'is_admin' => $this->isAdmin(),
            'avatar_url' => $this->getAvatarUrl(),
            'timezone' => $this->timezone,
            'locale' => $this->locale,
            'preferences' => $this->preferences ?? [],
            'last_login_at' => $this->last_login_at?->toIso8601String(),
            'last_login_ip' => $this->last_login_ip,
            'login_count' => $this->login_count ?? 0,
        ];
    }
    
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function with($request)
    {
        return [
            'meta' => [
                'version' => '1.0',
                'timestamp' => now()->toIso8601String(),
                'is_admin' => $this->isAdmin(),
                'permissions' => $this->when($this->relationLoaded('roles'), function() {
                    return $this->getAllPermissions()->pluck('name');
                }),
            ],
        ];
    }
}
