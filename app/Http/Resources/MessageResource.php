<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $isAuthor = $this->user_id === request()->user()->id;

        return [
            'description' => $this->description,
            'user' => $this->user->only(['name']),
            'author' => $isAuthor
        ];
    }
}
