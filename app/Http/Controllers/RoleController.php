<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class RoleController extends Controller
{   
    //all users are displayed
    public function index()
    {
        echo 'All roles are displayed';
        
        $role =  Role::all();
        return response()->json($role);
    }

     //display single record using id 
     public function show($id)
     {
          echo 'a single entry is shown.';
          
          $role = Role::find($id);
          return response()->json($role);
     }

      //update all feilds of a record
    public function update(Request $request, $id)
    {
        echo 'record is updated';
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->description = $request->input('description');
        $role->save();
        return response()->json($role);   
    }

     //delete a record
     public function destroy(Request $request, $id)
     {
        echo 'role is deleted';
        $role = Role::find($id);
        $role->delete();
        return response()->json($role);
     }

    //role is registered in the database 
    public function store(Request $request)
        {
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                ]);

            if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
            }

            $role = Role::create([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
            ]);

            $token = JWTAuth::fromUser($role);

            return response()->json(compact('role','token'),201);
        }

        public function login(Request $request)
        {
            $credentials = $request->only('name');
            $token = JWTAuth::attempt($credentials);

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }

}
