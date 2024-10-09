<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sanctum\PersonalAccessToken;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LogInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=User::all();
        return response()->json($user);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $roles=Role::where('name','user');
        $user->roles()->attach($roles);

        $token = $user->createToken('RoleToken')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user=User::find($id);
        return response()->json($user);
    }

    public function login(Request $request)
    {
        // التحقق من البيانات المدخلة

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response=array(['response'=>$validator->messages(),'success'=>false]);
            return $response;
        }


        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $user = User::where('email', $request->email)->first();

        //$roles=$user->roles()->pluck('name')->toArray();
        $token = $user->createToken('RoleToken')->plainTextToken;


        return response()->json(['token' => $token, 'user' => $user], 200);
    }

    public function logout(Request $request)
    {

        $user = Auth::user();


        if ($user) {

            $user->tokens()->delete();
            return response()->json(['message' => 'Successfully logged out'], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        else{

            $user=User::find($id);
            $user->name= $request->name;
            $user->email=$request->email;
            $user->password=$request->password;
            $user->save();
            return response()->json($user);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=User::find($id);
        if ($user){
            $user->delete();
            $response=array(['response'=>'the user deleted','success'=>true]);
            return $response;

        }
        else{
            $response=array(['response'=>'the user not found','success'=>false]);
            return $response;
        }
    }
}
