<?php

namespace App\Http\Resources\Management\User;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffUser extends JsonResource
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
            'gender' => $this->gender,
            'birth_day' => $this->birth_day,
            'nic' => $this->nic,
            'register_date' => $this->register_date,
            'state' => $this->state,
            'email' => $this->email,
            'roles' => $this->roles()->pluck('name')
        ];
    }
}
