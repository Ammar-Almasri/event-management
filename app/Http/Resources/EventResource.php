<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'start_time' => $this->start_time->format('Y-m-d H:i'),
                'end_time' => $this->end_time->format('Y-m-d H:i'),
                'user' => new UserResource($this->whenLoaded('user')),
                'attendees' => AttendeeResource::collection($this->whenLoaded('attendees'))
            ];
    }
}
