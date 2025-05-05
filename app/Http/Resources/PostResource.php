<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'is_published' => $this->is_published,
            'publish_date' => $this->publish_date,
            'meta_description' => $this->meta_description,
            'tags' => $this->tags,
            'keywords' => $this->tags,
        ];
    }
}
