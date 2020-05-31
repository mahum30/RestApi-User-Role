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
    public function index(Role $role)
    {
        echo 'All roles are displayed';
        $role =  Role::all();
        return response()->json($role);
    }

     //display single record using id 
     public function show(Role $role)
     {
          echo 'a single entry is shown.';
          return response()->json($role);
     }

      //update all feilds of a record
    public function update(Request $request, Role $role)
    {
        echo 'record is updated';
        $role->name = $request->input('name');
        $role->description = $request->input('description');
        $role->save();
        return response()->json($role);   
    }

     //delete a record
     public function destroy(Request $request, Role $role)
     {
        echo 'role is deleted';
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

}
