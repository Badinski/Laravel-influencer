<?php

namespace App\Http\Controllers\Admin;
use App\Http\Resources\RoleResource;
use App\Role;
use Illuminate\Http\Request;

class RoleController
{
   
    public function index()
    {
        \Gate::authorize('view', 'roles');

        return RoleResource::collection(Role::all());
    }

   
    public function store(Request $request)
    {
        \Gate::authorize('edit', 'roles');

        $role = Role::create($request->only('name'));

        if ($permissions = $request->input('permissions')) {
            foreach ($permissions as $permission_id) {
                \DB::table('role_permission')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id,
                ]);
            }
        }

        return response(new RoleResource($role),201);
    }

   
    public function show($id)
    {
        \Gate::authorize('view', 'roles');

        return new RoleResource(Role::find($id));
    }

    
    public function update(Request $request, $id)
    {
        \Gate::authorize('edit', 'roles');

        $role = Role::find($id);

        $role->update($request->only('name'));

        \DB::table('role_permission')->where('role_id', $role->id)->delete();

        if ($permissions = $request->input('permissions')) {
            foreach ($permissions as $permission_id) {
                \DB::table('role_permission')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id,
                ]);
            }
        }

        return response(new RoleResource($role), 202);
    }

    
    public function destroy($id)
    {
        \Gate::authorize('edit', 'roles');
        
        \DB::table('role_permission')->where('role_id', $id)->delete();

        $role = Role::destroy($id);

        return response(new RoleResource($role), 204);
    }
}
