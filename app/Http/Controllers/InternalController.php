<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Genre_file;
use App\Department;
use App\File;
use DB;

class InternalController extends Controller
{
    
    public function index(Request $request){
        
        $d=auth::user()->department_id;                  
        $departments = Department::where('id','<>',$d)->get();
        $genre_files_departments=Department::find($d)->followings()->get();
        $genre_files = Genre_file::where('department_id', $d)->orderby('sort_no','asc')->get(); 
        //$genre_files = $genre_files->concat($genre_files_departments);        
        
        if($request->has('sfile_id')){
            session()->put('file_id',$request->sfile_id);
        }
        return view('internals.internal',compact('genre_files','departments','request'));
    }
    public function other_internal(Request $request){
        
        $d=$request->department_id;
        
        $departments = Department::where('id','<>',auth::user()->department_id)->get();
        
        $genre_files=Genre_file::where('department_id',$d)->get();
        $request->session()->forget('file_id');
        return view('internals.otherinternal',compact('genre_files','departments','request'));
    }

    public function upload(Request $request){
        $genre_file_id=$request->file_id;
        $exists = Storage::disk('public')->exists('/files/'.$genre_file_id);    
        $directory = '/public/files/'.$genre_file_id;
        $files = $request->file('files');
        
        foreach ($files as $file) {
            $extension= $file->getClientOriginalExtension();        
            $name=basename($file->getClientOriginalName(),'.'.$extension );
             
            $items = File::where('name',$name)->where('genre_file_id',$genre_file_id)->max('branch');
            if($items == 0){
                $branch=1;
            }else{            
                $branch = $items+1;
            }
            Storage::putFileAs($directory, $file, $name.'_'.$branch.'.'.$extension); 
            File::create(compact('genre_file_id','name','branch','extension')); 
            $genre_files=Genre_file::where('department_id', Auth::user()->department_id)->orderby('sort_no','asc')->get();
            session()->put('file_id',$request->file_id);
            $departments = Department::where('id','<>',auth::user()->department_id)->get();
            return view('internals.internal',compact('genre_files','departments'));
        }

    } 

}
