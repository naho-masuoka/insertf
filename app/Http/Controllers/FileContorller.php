<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Filegenre;

class FileContorller extends Controller
{
    public function index(){
        $filegenres=Filegenre::where('department_id', Auth::user()->department_id);
        return view('internals.internal',compact('filegenres'));

    }

    
}
