<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Department;
use Auth;

class RegisterController extends Controller
{
    

    public function __construct()
    {
        $this->middleware('guest');
    }
    protected $redirectTo = '/list';
    
    public function showRegistrationForm()
    {
        $departments= Department::all();
        return view('auth.register',compact('departments'));
    }
    
    
    public function register(Request $request)
    {
        $rules = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'department_id' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
            'password' => Hash::make($request->password),
        ]);
        

        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
            return redirect()->route('project.index');
        }
        
    }

    
}
