<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'irs_id' => $this->irs_id,
            'stamp' => $this->stamp,
            'meta_data' => $this->meta_data,
            'contact_info' => $this->contact_info,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'deleted_at' => $this->when($this->trashed(), $this->deleted_at?->toIso8601String()),
            
            // Relationships
            'venues' => VenueResource::collection($this->whenLoaded('venues')),
            'employees' => EmployeeResource::collection($this->whenLoaded('employees')),
            
            // Counts
            'venues_count' => $this->whenCounted('venues'),
            'employees_count' => $this->whenCounted('employees'),
        ];
    }
}
