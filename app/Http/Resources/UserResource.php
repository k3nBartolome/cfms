<?php
// In app/Http/Resources/UserResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles->pluck('name') ?? [],
            'roles.permissions' => $this->getPermissionsViaRoles()->pluck('name') ?? [],
            'permissions' => $this->permissions->pluck('name') ?? [],
            'assigned_sites' => $this->sites->pluck('name') ?? [], // Get the assigned sites
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
