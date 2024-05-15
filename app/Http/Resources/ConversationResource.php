<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
            'uuid' => $this->uuid,
            'name' => $this->name ?: $this->members->where('id', '!=', auth()->id())->first()->name,
            'last_name' => $this->members->where('id', '!=', auth()->id())->first()->last_name,
            'image' => $this->members->where('id', '!=', auth()->id())->first()->image,
            'last_message' => $this->messages()->get()->pluck('content')->last(),
            'last_message_date' => $this->messages()->get()->pluck('created_at')->last(),
            'isRead' => fake()->boolean(),
        ];
    }
}
