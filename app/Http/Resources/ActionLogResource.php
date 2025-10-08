<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActionLogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'action' => $this->action,
            'model_type' => $this->model_type,
            'model_id' => $this->model_id,
            'old_data' => $this->old_data,
            'new_data' => $this->new_data,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'created_at' => $this->created_at?->toIso8601String(),
            
            // Relationships
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'model' => $this->when($this->relationLoaded('model'), function() {
                $modelClass = $this->model_type;
                $resourceClass = 'App\\Http\\Resources\\\\' . class_basename($modelClass) . 'Resource';
                
                if (class_exists($resourceClass)) {
                    return new $resourceClass($this->model);
                }
                
                return $this->model;
            }),
            
            // Computed
            'action_type' => $this->action_type,
            'action_description' => $this->action_description,
            'model_name' => $this->model_name,
            'created_at_formatted' => $this->created_at?->format('Y-m-d H:i:s'),
            'created_at_human' => $this->created_at?->diffForHumans(),
        ];
    }
}
