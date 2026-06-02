<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'image' => $this->image ? url('storage/images/profile_pictures/', $this->image) : url('images_cus/profile_pic/default.jpg'),
            'roles' => $this->roles,
            'permissions' => $this->users_permissions()
        ];
    }
}
