<?php

namespace App\Http\Resources\Management;

use App\Http\Resources\Management\Permission as PermissionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
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
            'name' => $this->name,
            'permissions' => $this->permissions->pluck('id')
            // 'permissions' => PermissionResource::collection($this->permissions)
        ];
    }
}
