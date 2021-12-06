<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Project;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function create(Request $request){
        $project=Project::where('id',$request->project_id)->get();
        $customer=null;
        $customers=Customer::where('project_id',$request->project_id)->get();
        $updateday = Carbon::now()->format('Y-m-d');  
        return view('customers.create',compact('project','customers','customer','updateday'));
    }

    public function edit(Request $request){
        $project=Project::where('id',$request->project_id)->get();
        $customer=Customer::find($request->id);
        $customers=Customer::where('project_id',$request->project_id)->get();
        $updateday = $customer->updateday->format('Y-m-d');  
        
        return view('customers.create',compact('project','customers','customer','updateday'));
    }

    public function store(Request $request){
        if(!isset($request->id)){
            $project_id = $request->project_id;
            $customer = $request->customer;
            $enduser = $request->enduser;
            $customer = $request->customer;
            $updateday = $request->updateday;
            $id = Customer::create(compact('project_id', 'customer', 'enduser', 'updateday'));
            $request['id'] = $id->id;
            $msg="作成完了しました。";
        }else{     
            $customer = Customer::find($request->id);
            $customer -> project_id = $request->project_id;
            $customer -> customer = $request->customer;
            $customer -> enduser = $request->enduser;
            $customer -> updateday = $request->updateday;        
            $customer->save();
            $msg="編集完了しました。";   
        }
        
        $project=Project::where('id',$request->project_id)->get();
        $customer=Customer::where('id',$request->id)->get();
        $updateday = $customer[0]->updateday->format('Y-m-d'); 
        $customers=Customer::where('project_id',$request->project_id)->get();
        return view('customers.create',compact('project','customers','customer','msg','updateday'));
    }
}
