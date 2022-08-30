<?php

namespace App\Http\Resources\Customer;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id'            => $this->id,
            "title"         => $this->title,
            "description"   => $this->description,
            "date"          => $this->created_at->format('d/m/Y H:i:s'),
            "author"        => $this->user->name === auth()->user()->name ? 'Me' : $this->user->name,
            "likes"         => $this->likes_count,
            "comments"      => Comment::collection($this->whenLoaded('Comments'))
        ];
    }
}
