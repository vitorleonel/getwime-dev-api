<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $author = $this->user_id === request()->user()->id;

        return [
            'id' => $this->public_id,
            'name' => $this->name,
            'description' => $this->description,
            'author' => $author
        ];
    }
}
