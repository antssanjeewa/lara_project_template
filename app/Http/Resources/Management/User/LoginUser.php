<?php

namespace App\Http\Resources\Management\User;

use Illuminate\Http\Resources\Json\JsonResource;

class LoginUser extends JsonResource
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
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'birth_day' => $this->birth_day,
            'nic' => $this->nic,
            'register_date' => $this->register_date,
            'state' => $this->state,
            'email' => $this->email,
            'roles' => $this->roles()->pluck('name'),
            'permissions' => $this->getPermissions()
        ];
    }

    // Get Permission List of User
    private function getPermissions(){
        $roles = $this->roles;
        $permissions = [];

        foreach ($roles as $role) {
            $permissionList = $role->permissions()->pluck('name');
            foreach ($permissionList as $permission) {
                if (!in_array($permission, $permissions)){
                    array_push($permissions,$permission);
                } 
            }
        }

        return $permissions;
    }
}
