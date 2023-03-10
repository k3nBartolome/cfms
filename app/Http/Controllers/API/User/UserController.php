<?php

namespace App\Http\Controllers\API\User;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return UserResource::collection($users);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'role' => 'sometimes|string|exists:roles,name'
    ]);

    //register user
    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password'])
    ]);
    //assign role and permission
    $user_role = ($validatedData['role']);
    $role_permission = Role::findByName($validatedData['role'])->permissions;
    if ($user_role) {
        $user->assignRole($user_role);
        $user->givePermissionTo($role_permission);
    }
    return new UserResource($user);
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::FindOrFail($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6',
            'role' => 'sometimes|string|exists:roles,name'
        ]);

       $user = User::FindOrFail($id);
       $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password'])
        ]);
        $user_role = ($validatedData['role']);
        $role_permission = Role::findByName($validatedData['role'])->permissions;
        if ($user_role) {
            $user->syncRoles($user_role);
            $user->syncPermissions($role_permission);
        }
        return new UserResource($user);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::FindOrFail($id);
        if ($user->delete()) {
            return new UserResource($user);
            }
        }
    }

