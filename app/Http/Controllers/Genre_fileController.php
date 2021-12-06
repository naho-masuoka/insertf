<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

use App\Genre_file;
use App\File;
use App\Department;
use DB;

class Genre_fileController extends Controller
{    
    public function index(Request $request){
         //dd($request);
        if(isset($request->genre_file_id)){
            $id=$request->genre_file_id;
            
            $did=Auth::user()->department_id;
            
            $departments= Department::whereHas('followings', function ($query) use($id){
                $query->where('genre_file_id', $id);
                })->get();
            $undepartments= Department::whereDoesntHave('followings', function ($query) use($id){
                $query->where('genre_file_id', $id);
                })->get();
            $genre_file = Genre_file::where('id', $id)->get();
            if($request->has('name')){
                $request->merge(['name' => $genre_file[0] ->name]);
            }
        }else{
            $departments = null;
            $undepartments=null;
            $query=null;
        }
        
        $genre_files_departments=Department::find(Auth::user()->department_id)->followings($request->department_id)->get();        
        $genre_files = Genre_file::where('department_id', Auth::user()->department_id)->orderby('sort_no','asc')->get();
        
        $genre_files = $genre_files->concat($genre_files_departments);
        //return redirect()->route('genre_file.index')->with(compact('genre_files','departments','undepartments','request'));
        return view('genre_files.index',compact('genre_files','departments','undepartments','request'));
    }
    
    
    public function create($id = false){
        
        $count = Genre_file::where('department_id',Auth::user()->department_id)->max('sort_no') + 1 ;
        if($id <> 0){            
            $genre_file = Genre_file::where('id',$id)->get();
        }else{
            $genre_file=null;
        }
        return view('genre_files.create',compact('id','genre_file','count'));
    }

    public function store(Request $request){
        
        if($request->id == null){            
            //create
            $department_id = Auth::user()->department_id; 
            $sort_no = $request->sort_no;           
            $name = $request->name;
            $genre_file=Genre_file::create(compact('department_id', 'sort_no', 'name'));            
            $id = $genre_file->id;
            $msg="登録完了しました。";
            $exists = Storage::disk('public')->exists($request->projectid);
            $directory = '/public/files/'.$id;
            Storage::makeDirectory($directory);    
        }else{        
            $genre_file = Genre_file::find($request->id);
            $genre_file->sort_no = $request->sort_no; 
            $genre_file->name = $request->name;        
            $genre_file->save();
            
            $id = $request->id;
            $msg="編集完了しました。";    
        }
        $count=null;
        return redirect('files/create/'.$id)->with(compact('genre_file','id','genre_file','count','msg'));
    }

  
    public function store_destroy(Request $request){;
        if($request->is_select == 1){
            DB::insert('insert into genre_files_departments (genre_file_id, department_id) VALUES (?,?)',[$request->genre_file_id, $request->department_id]);
        }else{
            DB::delete('delete from genre_files_departments where genre_file_id = '.$request->genre_file_id. ' and department_id =' .$request->department_id);
        }
        $id=$request->genre_file_id;
            
        $did=Auth::user()->department_id;
        
        $departments= Department::whereHas('followings', function ($query) use($id){
            $query->where('genre_file_id', $id);
            })->get();
        $undepartments= Department::whereDoesntHave('followings', function ($query) use($id){
            $query->where('genre_file_id', $id);
            })->get();
        $genre_file = Genre_file::where('id', $id)->get();
        if($request->has('name')){
            $request->merge(['name' => $genre_file[0] ->name]);
        }

        $genre_files_departments=Department::find(Auth::user()->department_id)->followings($request->department_id)->get();        
        $genre_files = Genre_file::where('department_id', Auth::user()->department_id)->orderby('sort_no','asc')->get();
        $genre_files = $genre_files->concat($genre_files_departments);
        return view('genre_files.index',compact('genre_files','departments','undepartments','request'));
    }
}
    
