<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'start' => $this->start?->toIso8601String(),
            'end' => $this->end?->toIso8601String(),
            'location' => $this->location,
            'description' => $this->description,
            'image' => $this->image,
            'image_url' => $this->image ? Storage::url($this->image) : null,
            'attendee_count' => $this->whenCounted('users'),
            'is_upcoming' => $this->start?->isFuture() ?? false,
            'is_ongoing' => $this->start?->isPast() && ($this->end?->isFuture() ?? false),
            'user_has_rsvped' => $this->when(
                auth()->check(),
                fn() => $this->users->contains(auth()->id())
            ),
            'attendees' => UserResource::collection($this->whenLoaded('users')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
