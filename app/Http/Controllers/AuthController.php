<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Hash;
use App\User;
use App\Http\Requests\RegisterRequest;

use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        /*The attempt method accepts an array of key / value pairs as its first argument. 
        The values in the array will be used to find the user in your database table.
         So, in the example above, the user will be retrieved by the value of the email 
         column. If the user is found, the hashed password stored in the database will
          be compared with the password value passed to the method via the array. 
          You should not hash the password specified as the password value, 
          since the framework will automatically hash the value before comparing 
          it to the hashed password in the database. If the 
        two hashed passwords match an authenticated session will be started for the user. */
        
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $scope = $request->input('scope');

            /*To issue a token, you may use the createToken method. 
            The createToken method returns a Laravel\Sanctum\NewAccessToken instance.
            
            */

            /*an API token is a unique identifier of an application requesting access to your service. 
            Your service would generate an API token for the application to use when requesting your service. 
            You can then match the token they provide to the one you store in order to authenticate. */
            
            if($user->isInfluencer() && $scope !== 'influencer'){
                return response([
                    'error' => 'Access denied!',
                ], Response::HTTP_FORBIDDEN);
            }
            
            $token = $user->createToken($scope, [$scope])->accessToken;


            /* authentication cookies are the most common method used by web servers to
             know whether the user is logged in or not, and which account they are logged 
             in with. Without such a mechanism, the site would not know whether to send a
              page containing sensitive information, or require the user to authenticate 
              themselves by logging in.  */
            $cookie = \cookie('jwt', $token, 3600);

            return \response([
                'token' => $token,
            ])->withCookie($cookie);
        }
        
        return response([
            'error' => 'Invalid Credentials!',
        ], 401);

        
    }

    public function logout(){
        $cookie = \Cookie::forget('jwt');
        
        return \response([
            'mesage' => 'success',
        ])->withCookie($cookie);
    }

    public function register(RegisterRequest $request)
    {   
        $user = User::create(
            $request->only('first_name', 'last_name', 'email')
            + [
                'password' => Hash::make($request->input('password')),
                'is_influencer' => 1
            ]
        );

        return response($user, 201);
    }

    public function user()
    {
      $user = \Auth::user();

      $resource = new UserResource($user);
      
      if($user->is_influencer)
      {
          return $resource;
      }

      return $resource->additional([
          'data' => [
              'permissions' => $user->permissions(),
          ],
      ]);

    }


    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = \Auth::user();

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response(new UserResource($user), 201);
    }

 
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = \Auth::user();

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return response(new UserResource($user), 201);
    }
}
