<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Project;
use App\Claim;
use App\Customer;
use App\Department;
use App\Document;
use App\Item;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


use Carbon\Carbon;

class ProjectController extends Controller      
{    
    public function index(Request $request){ 
           
        $departments=Department::orderby('id')->get();
        if($request->has('search')){
            $keywords = $request->search;
            $projects = Project::where('keywords','like',"%$keywords%")->orderbyDESC('id')->get();
        }else{
            if($request->id <> null){
                $id=$request->id;
                $projects = Project::where('id', $id)->orderbyDESC('id')
                    ->with(['items'=> function($query){$query->orderby('department_id','asc');}])
                    ->with('claim_items')
                    ->with('claims')
                    ->with('customers')
                    ->with('finaldocuments')
                    ->get();
            }else{
                $projects=Project::orderbyDESC('id')->get();
            }         
        }
        
        if($projects->count() == 0 || $projects->count() <> 1){
            $p = null;
        }elseif($projects->count() == 1){
            $p = $projects[0];
        }
        return view('projects.projects',compact('departments','projects','p'));
    }    
    public function updateproject(Request $request){
        $this->validate($request, [
            'id' => ['nullable','regex:/^[a-zA-Z0-9]+$/'],
            'prepareid' => ['required','regex:/^[a-zA-Z0-9]+$/'],
            'projectid' => ['nullable','regex:/^[a-zA-Z0-9]+$/'],
            'machineid' => ['nullable','regex:/^[a-zA-Z0-9]+$/'],
        ], [
            'id.regex' => '半角英数字以外の入力は出来ません',
            'prepareid.required' => '必須入力です',
            'projectid.regex' => '半角英数字以外の入力は出来ません',
            'machineid.regex' => '半角英数字以外の入力は出来ません',
            'prepareid.regex' => '半角英数字以外の入力は出来ません',
        ]);
        $keyword=$request->prepareid.$request->projectid.$request->machineid.$request->customer.$request->enduser;

        if(!isset($request->id)){
            $prepareid = $request->prepareid;
            $projectid = $request->projectid;
            $machineid = $request->machineid;
            $keywords = $keyword;
            $customer = $request->customer;
            $enduser = $request->enduser;
            $project = Project::create(compact('prepareid', 'projectid', 'machineid', 'customer','enduser','keywords'));
            $id = $project ->id; 
        }else{     
            $project = Project::find($request->id);
            $project -> prepareid = $request->prepareid;
            $project -> projectid = $request->projectid;
            $project -> machineid = $request->machineid;
            $project -> keywords = $keyword;
            $project -> customer = $request->customer;
            $project -> enduser = $request->enduser;           
            $project->save(); 
            $id=$request->id;
            
        }
        return redirect('/list?id='.$id);
    }
    public function folders($id){
        $exists = Storage::disk('public')->exists('/projects/'.$id);
        $directory = '/public/projects/'.$id;
        
        $departments=Department::all();  
        if($exists == false){
            Storage::makeDirectory($directory);
            Storage::makeDirectory($directory.'/finaldocuments');
            Storage::makeDirectory($directory.'/claims');  
            foreach($departments as $d){
                Storage::makeDirectory($directory.'/'.$d->id);
            }
        }
        return $departments;
    }

    public function finaldocumentsupload(Request $request){
        $this->validate($request, [
            'id' => ['required'],
        ], [
           'id.required' => 'プロジェクトを特定してください。',
        ]);
        $directory=$this->folders($request->id);
        
        $genre_id =1;
        $directory = $directory = '/public/projects/'.$request->id.'/finaldocuments';
        $department_id = 3;
        $project_id = $request->id;
        $files = $request->file('files');
        foreach ($files as $file) {
            $extension= $file->getClientOriginalExtension();        
            $name=basename($file->getClientOriginalName(),'.'.$extension );
            
            $items = Item::where('name',$name)->where('genre_id',$genre_id)->max('branch');
            
            if($items ==null || $items == 0){
                $branch=1;
            }else{            
                $branch = $items+1;
            }
            Storage::putFileAs($directory, $file, $name.'_'.$branch.'.'.$extension); 
            Item::create(compact('department_id', 'project_id', 'name','branch','extension','genre_id',));        
        }
        return redirect('/list?id='.$request->id);
    }
    public function documentsupload(Request $request){
        
        $this->validate($request, [
            'id' => ['required'],
            'file_name'=> ['required'],
            'file' => ['required']
        ], [
            'id.required' => 'プロジェクトを特定してください',
            'file_name.required' => '書類名は必須です。',
            'file.required' => 'ファイルは必ず選択してください。',
        ]);
        
        $project_id=$request->id;
        $departments = $this->folders($project_id);
        $department_id=Auth::user()->department_id;        
        
        $directory = $directory = '/public/projects/'.$project_id.'/'.$department_id;
        
        $extension= $request->file('file')->getClientOriginalExtension();        
        $filename=basename($request->file('file')->getClientOriginalName(),'.'.$extension );  
        $carbon = Carbon::now();
        $carbon = $carbon->format('Ymd');
        $name = $carbon.'_'.$request->file_name;
        $items = Item::where('name',$name)->max('branch');
        if($items == 0){
            $branch=1;
        }else{            
            $branch = $items+1;
        }
        Storage::putFileAs($directory,$request->file('file'), $name.'_'.$branch.'.'.$extension);
        
        Item::create(compact('department_id', 'project_id', 'name','branch','extension'));
        return redirect('/list?id='.$project_id);
    }    
    public function fdelete(Request $request){
        Storage::delete($request->fname);
        $f_data= new Item;
        Item::where('id',$request->fid)->delete();
        
        return redirect('/list?id='.$request->project_id);
    }
}
