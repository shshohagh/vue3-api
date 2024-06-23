<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Validator;

class UsersApiController extends Controller
{
    public function index(){

        $users =  User::all();
        return UserResource::collection($users);

    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'password' => 'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        }else{
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            if($user){
                return response()->json([
                    'status' => 200,
                    'message' => 'User Added Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Somthing Went Wrong'
                ], 500);
            }
        }

    }

    public function showById($id){
        $users =  User::find($id);
        if($users){
            return new UserResource($users);
        }else{
            return response()->json(['Error' => 'Data Not Found!'], 404);
        }
    }

    public function update($id){
        request()->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $user =  User::find($id);
        if($user){

            $user->name = request('name');
            $user->email = request('email');
            $user->save();

            return new UserResource($user);
        }else{
            return response()->json(['Error' => 'Data Not Found!'], 404);
        }
    }
    public function destroy($id){
        $user =  User::find($id);
        if($user){
            $user->delete();
            return new UserResource($user);
        }else{
            return response()->json(['Error' => 'Data Not Found!'], 404);
        }
    }
}
