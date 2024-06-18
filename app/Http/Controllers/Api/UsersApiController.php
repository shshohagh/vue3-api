<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User as UserResource;

class UsersApiController extends Controller
{
    public function index(){

        $users =  User::all();
        return UserResource::collection($users);

    }
    public function store(){
        request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        /* return User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password'),
        ]); */

        $user = new User;
        $user->name = request('name');
        $user->email = request('email');
        $user->password = request('password');
        $user->save();

        return new UserResource($user);
    }

    public function showById($id){
        $users =  User::find($id);
        if($users){
            return new UserResource($users);
        }else{
            return response()->jsone(['Error' => 'Data Not Found!'], 404);
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
            return response()->jsone(['Error' => 'Data Not Found!'], 404);
        }
    }
    public function destroy($id){
        $user =  User::find($id);
        if($user){
            $user->delete();
            return new UserResource($user);
        }else{
            return response()->jsone(['Error' => 'Data Not Found!'], 404);
        }
    }
}
