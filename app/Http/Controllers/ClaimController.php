<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Claim;
use App\Item;
use App\Project;
use App\Department;

use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ClaimController extends Controller
{
    public function create(Request $request){
        if($request->has('project_name')){
        }else{
           $project=Project::where('id',$request->project_id)->get();
           $request->merge(['project_name' => $project[0]->projectid]);
        }     
        if(!isset($request->claim_id)){            
            //create
            $claim=null;           
            $carbon = Carbon::now();
            $request['workingday'] = $carbon->format('Y-m-d');
        }else{
            //edit
            $claim =Claim::where('id','=',$request->claim_id)
                ->with('items')
                ->get();
            $request['workingday'] = $claim[0]->workingday->format('Y-m-d');
        }
        $claims = Claim::where('project_id','=',$request->project_id)->get();
        return view('claims.create',compact('request','claim','claims'));
    }
    
    public function store(Request $request){
        if($request->claim_id == null){             
            //claim_create
            $project_id = $request->project_id;            
            $machineid = $request->machineid;
            $workingday = $request->workingday;
            $department_id = Auth::user()->department_id;
            $memo = $request->memo;            
            $id=Claim::create(compact('project_id', 'machineid', 'department_id', 'workingday', 'memo'));
            $request['claim_id'] = $id->id;
            $msg="登録完了しました。";
        }else{            
            //claim_edit           
            $claim = Claim::find($request->claim_id);            
            $claim -> machineid = $request->machineid;
            $claim -> department_id = Auth::user()->department_id;
            $claim-> workingday = $request->workingday;
            $claim-> memo = $request->memo;           
            $claim->save();
            $msg="編集完了しました。";
        }
        $exists = Storage::disk('public')->exists('/projects/'.$request->project_id);
        $directory = '/public/projects/'.$request->project_id;
        
        if($exists ==false){
            Storage::makeDirectory($directory);
            Storage::makeDirectory($directory.'/finaldocuments');
            Storage::makeDirectory($directory.'/claims');
            $departments=Department::all();
            foreach($departments as $d){
                Storage::makeDirectory($directory.'/'.$d->id);
            }    
        }
        
        //ファイル
        $directory = $directory.'/claims/'.$request->claim_id;
        $claim_id=$request->claim_id;
        $genre_id =2;
        $department_id = Auth::user()->department_id;
        $project_id=$request->project_id;
        $machineid = $request->machineid;
        
        $files = $request->file('files');

        if($files<>null){            
            foreach ($files as $file) {            
                $extension= $file->getClientOriginalExtension();
                $filename=basename( $file->getClientOriginalName(),'.'.$extension );  
                $name = $filename;
                $item=Item::where('claim_id',$request->id)->where('name',$filename)->max('branch');
                if($item == 0){     
                    $branch =1;
                }else{    
                    $item+=1;
                    $branch=$item;
                    
                }
                Item::create(compact('department_id', 'project_id', 'claim_id', 'name', 'branch','extension', 'genre_id',));
                $name=$name.'_'.$branch.'.'.$extension;
                Storage::putFileAs($directory,$file,$name); 
            }
        }
        $claim =Claim::where('id','=',$request->claim_id)
                ->with('items')
                ->get();
        $claims = Claim::where('project_id','=',$request->project_id)->get();
        return view('claims.create',compact('request','claims','claim','msg'));
    }

    public function fdelete(Request $request){
        Storage::delete($request->fname);        
        Item::where('id',$request->item_id)->delete();        
        $claim =Claim::where('id','=',$request->claim_id)
        ->with('items')
        ->get();
        $msg="アイテムを削除しました";
        return view('claims.create',compact('request','claim','msg'));
    }
};
