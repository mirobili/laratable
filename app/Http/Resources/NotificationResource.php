<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'notifiable_type' => $this->notifiable_type,
            'notifiable_id' => $this->notifiable_id,
            'type' => $this->type,
            'data' => $this->data,
            'read_at' => $this->read_at?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            
            // Relationships
            'notifiable' => $this->when($this->relationLoaded('notifiable'), function() {
                $modelClass = get_class($this->notifiable);
                $resourceClass = 'App\\Http\\Resources\\\\' . class_basename($modelClass) . 'Resource';
                
                if (class_exists($resourceClass)) {
                    return new $resourceClass($this->notifiable);
                }
                
                return $this->notifiable;
            }),
            
            // Computed
            'is_read' => $this->read_at !== null,
            'created_at_formatted' => $this->created_at?->format('Y-m-d H:i:s'),
            'created_at_human' => $this->created_at?->diffForHumans(),
            'title' => $this->title,
            'message' => $this->message,
            'icon' => $this->icon,
            'url' => $this->url,
            'priority' => $this->priority,
        ];
    }
}
