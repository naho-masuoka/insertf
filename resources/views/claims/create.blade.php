@extends('layouts.app')
@section('content') 
<div class="container-fluid">
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-sm-4 col-md-7">
            @if(isset($msg))
                <div class="alert alert-dismissible fade show" role="alert" style="background-color:#6b778d;color:white;">
                    {{ $msg }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>    
                </div>
            @endif
            <div class="row justify-content-end"> 
                <a href="/list/?id={{ $request->project_id}}" class="btn mybtn m-3">戻る</a>
            </div>
            <div>
                <form method="POST" action="/claims/store" enctype="multipart/form-data">
                    {{ csrf_field() }}    
                    <div class="row d-flex justify-content-between">    
                        <div class="form-group col-md-4 col-xs-10">                    
                            <input type="hidden" name="claim_id" class="form-control" value="{{ $request->claim_id }}">                     
                            <input type="hidden" name="project_id" class="form-control" value="{{ $request->project_id }}">  
                            <label>Project</label>
                            <input type="text" name="project_name" class="form-control" value="{{ $request->project_name }}" readonly>             
                        </div>
                        <div class="form-group col-md-4 col-xs-10">
                            <label>機械番号</label>
                            <input type="text" name="machineid" class="form-control" value="{{ $request->machineid }}">
                        </div>
                        <div class="form-group col-md-4 col-xs-10">
                            <label>作業日</label>
                            <input type="date" name="workingday" class="form-control" value="{{ $request->workingday }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>作業内容</label>
                        <textarea name="memo" class="form-control" rows="10">{{$request->memo}}</textarea>
                    </div>
                    @if(Auth::user()->department_id == 3)
                        <div class="form-group">
                            <input type="file" multiple name="files[]" class="form-control-file">
                        </div>
                        <button type="submit" class="form-control btn mybtn mt-2">                    
                            @if(isset($request->claim_id))
                                上書保存
                            @else
                                新規作成
                            @endif
                        </button>
                    @endif
                </form>
                @if(isset($request->claim_id))
                    <div class="p-1 mt-4" style="background-color:#001871;">
                        <a style="font-weight:bold;color:white;">保存済みファイル</a>                      
                    </div>
                @endif
</br>
                <ui class="list-group list-group-flush">                  
                    @if($claim <> null)      
                        @foreach($claim[0]->items as $item)
                            <div class="row"> 
                                @if(Auth::user()->department_id == 3)                   
                                    <form method="POST" action="/claims/fdelete">                
                                        {{ csrf_field() }}  
                                        <button type=submit class="btn mybtn ml-3 mb-1" name="btn" style="padding-bottom:0;">削除</button>
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        <input type="hidden" name="claim_id" value="{{ $request->claim_id }}">
                                        <input type="hidden" name="project_id" value="{{ $request->project_id }}">
                                        <input type="hidden" name="project_name" value="{{ $request->project_name }}">                                
                                        <input type="hidden" name="machineid" value="{{ $request->machineid }}"> 
                                        <input type="hidden" name="workingday" value="{{ $request->workingday }}">
                                        <input type="hidden" name="memo" value="{{ $request->memo }}"> 
                                        <input type="hidden" name="fname" value="{{ 'public/projects/'. $request->project_id . '/claims/' . $item->claim_id .'/' . $item->name.'_'.$item->branch.'.'.$item->extension }}">     
                                    </form>                                    
                                @endif
                                <li class="ml-2" style="list-style: none;">
                                    <div class="d-flex flex-row">
                                        <div class="col-10">
                                            <a href="{{ asset('/storage/projects/'. $request->project_id . '/claims/'. $item->claim_id .'/'. $item->name.'_'.$item->branch.'.'.$item->extension ) }}" class="ml-3">
                                                {{ $item->name.'_'.$item->branch.'.'.$item->extension }}
                                            <a>
                                        </div>
                                        <div class="col-2">
                                            {{ $item->created_at->format('y/m/d') }}
                                        </div>
                                    </div>       
                                </li>

                                <a>  
                            </div>
                        @endforeach
                    @endif          
                </ui>
            </div>
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-sm-4 col-md-3">
            <div class="p-1" style="background-color:#001871;">
                <a href="/list" style="font-weight:bold;color:white; ">クレーム一覧</a>                        
            </div>
                    
            <table class="table table-sm mt-2">
                <tr>
                    <th style="width:5%;border: none;font-weight:bold">ID</th>
                    <th style="width:20%;border: none;font-weight:bold">機械番号</th>
                    <th style="width:20%;border: none;font-weight:bold">作業日</th>
                    <th style="width:55%;border: none;font-weight:bold">memo
                    <th>
                </tr>
                    @foreach($claims as $c)
                    
                        <tr>
                            <td>
                                <form action="/claims/create" method="post">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn small" style="padding:0 0;color:blue; font:bold">{{
                                        $c -> id}}</button>
                                    <input type="hidden" name="claim_id" value="{{ $c -> id }}">
                                    <input type="hidden" name="project_id" value="{{ $c ->project_id}}">
                                    <input type="hidden" name="machineid" value="{{ $c -> machineid}}">
                                    <input type="hidden" name="workingday" value="{{ $c -> workingday }}">
                                    <input type="hidden" name="memo" value="{{ $c -> memo }}">
                                </form>
                            </td>
                            <td><div class="wrap-text">{{ $c-> machineid }}</div></td>
                            <td><div class="wrap-text">{{ $c -> workingday->format('y/m/d') }}</div></td>
                            <td><div class="wrap-text">{{ $c -> memo }}</div></td>
                        </tr>
                        
                    @endforeach
            </table>
        </div>
    </div>        
</div>
@endsection