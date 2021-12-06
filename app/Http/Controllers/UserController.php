<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\User;

class UserController extends Controller
{
    public function index(){
        $departments=Department::all();
        return view('users.user', compact('departments'));
    }

    public function update(Request $request){
        $user = User::find($request->id);
        $user -> email = $request->email;
        $user -> department_id = $request->department_id;      
        $user->save();
        $msg="編集完了しました。";
        $departments=Department::all();
        return view('users.user', compact('departments','msg'));
    }
}
