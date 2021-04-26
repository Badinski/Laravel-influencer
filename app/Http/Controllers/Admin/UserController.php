<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
class UserController
{
  public function index() {
     \Gate::authorize('view', "users");

      $users = User::with('role')->paginate();
      
      return UserResource::collection($users);
  }

  public function show($id) {
    \Gate::authorize('view', "users");

    $user = User::with('role')->find($id);

    return new UserResource($user);
  }

  public function store(UserCreateRequest $request) {
    \Gate::authorize('edit', "users");


    $user = User::create(
      $request->only('first_name', 'last_name', 'email')
      + ['password' => Hash::make(1234)]
      );

      UserRole::create([
        'user_id' => $user->id,
        'role_id' => $request->input('role_id'),
      ]);

    return response(new UserResource($user), 201);
  }

  public function update(UserUpdateRequest $request,$id) {
    \Gate::authorize('edit', "users");

    
    $user = User::find($id);


    /*If you need to retrieve a subset of the input data, you may use the only method*/ 
    $user->update($request->only('first_name', 'last_name', 'email'));

    UserRole::where('user_id', $user->id)->delete();

    UserRole::create([
      'user_id' => $user->id,
      'role_id' => $request->input('role_id'),
    ]);

    return response(new UserResource($user),202);

  }
  public function destroy($id) {
    User::destroy($id);

    return response(null,204);
  }
}
