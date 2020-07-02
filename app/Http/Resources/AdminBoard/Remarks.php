<?php

namespace App\Http\Resources\AdminBoard;

use Illuminate\Http\Resources\Json\JsonResource;

class Remarks extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'remarkable_id'=>$this->remarkable_id,
            'remarkable_type'=>$this->remarkable_type,
            'user_name' => $this->user->name,
            'obj' => $this->remarkable,
            'created_at' => (string)$this->created_at
        ];
    }
}
