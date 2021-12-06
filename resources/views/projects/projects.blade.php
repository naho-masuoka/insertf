@extends('layouts.app')
@section('content')
<?php
    $user=Auth::user();
    if($projects->count() == 1){
        $p=$projects[0];
    }else{
        $p=null;
    }

?>
<div class="container-fluid">
    <div class="row">
        <!--　左サイド　-->
        <div class="col-sm-4 col-md-2">
            <div class="d-none d-md-block">
                <div class="card mx-auto mb-2" style="width: 20rem;">
                    @if(!isset($project))
                        <h5 class="card-title text-center mt-3" style="margin-bottom:0;font-weight:bold;">表示物件</h5>
                    @else
                        <h5 class="card-title text-center mt-3" style="margin-bottom:0;font-weight:bold;">物件内容</h5>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="list/updateproject">
                            {{ csrf_field() }}
                            <div class="col">
                                <input type="text" name="id" class="form-control @error('id') is-invalid @enderror"
                                    placeholder="ID"
                                    value="{{ old('id', isset($project)==true ? $project->id : '') }}">
                                <div class="invalid-feedback">
                                    @error('id')
                                    <div><small>{{ $message }}</small></div>
                                    @enderror
                                    <br>
                                </div>
                            </div>
                            <div class="col">
                                <input type="text" name="prepareid"
                                    class="form-control @error('prepareid') is-invalid @enderror" placeholder="E番"
                                    value="{{ old('prepareid', isset($project)==true ? $project->prepareid : '') }}">
                                <div class="invalid-feedback">
                                    @error('prepareid')
                                    <div><small>{{ $message }}</small></div>
                                    @enderror
                                    <br>
                                </div>
                            </div>
                            <div class="col">
                                <input type="text" name="projectid"
                                    class="form-control @error('projectid') is-invalid @enderror" placeholder="工事番号"
                                    value="{{ old('projectid', isset($project)==true ? $project->projectid : '') }}">
                                <div class="invalid-feedback">
                                    @error('projectid')
                                    <div><small>{{ $message }}</small></div>
                                    @enderror
                                    <br>
                                </div>
                            </div>
                            <div class="col">
                                <input type="text" name="machineid"
                                    class="form-control @error('machineid') is-invalid @enderror" placeholder="機械番号"
                                    value="{{ old('machineid', isset($project)==true ? $project->machineid : '') }}">
                                <div class="invalid-feedback">
                                    @error('machined')
                                    <div><small>{{ $message }}</small></div>
                                    @enderror
                                    <br>
                                </div>
                            </div>
                            <div class="col">
                                <input type="text" name="customer" class="form-control" placeholder="契約先"
                                    value="{{ old('customer', isset($project)==true ? $project->customer: '') }}">
                            </div>
                            <div class="col">
                                <input type="text" name="enduser" class="form-control" placeholder="納入先"
                                    value="{{ old('enduser', isset($project)==true ? $project->enduser : '') }}">
                            </div>
                            <div class="col">
                                <button type="submit" class="form-control btn mt-2 mybtn">登録</button>
                            </div>
                        </form>
                    </div>
                </div>
                @if($p <> null) <!--ファイル登録 -->
                    <div class="card mx-auto mb-2" style="width: 20rem;">
                        <h5 class="card-title text-center mt-3" style="margin-bottom:0;font-weight:bold;">ファイル登録</h5>
                        <div class="card-body">
                            <form method="POST" action="list/documentsupload" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="prepareid"
                                    class="form-control @error('prepareid') is-invalid @enderror"
                                    value="{{ old('prepareid', $projects->count()==1 ? $projects[0]->prepareid : '') }}">
                                <input type="hidden" name="id"
                                    class="form-control @error('projectidd') is-invalid @enderror"
                                    value="{{ old('id', $projects->count()==1 ? $projects[0]->id : '') }}">
                                <div class="invalid-feedback text-center">
                                    @error('id')
                                    <div>
                                        <h6 style="font-weight:bold;">{{ $message }}</h6>
                                    </div>
                                    @enderror
                                    <br>
                                </div>
                                @if(isset($project)==true)
                                <div class="text-center">
                                    <h6 class="p-1" style="font-weight:bold;">物件番号:{{ $projects[0]->prepareid }}</h6>
                                </div>
                                @endif
                                <div class="form-group d-flex justify-content-center" style="margin-bottom:0;">
                                    <select id="Select1" class="form-group form-control" onchange="selectboxChange()">
                                        @foreach($user->department->documents as $document)
                                        {{$document}}
                                        <option value="{{ $document->name }}">{{ $document->name }}</option>
                                        @endforeach
                                    </select>
                                    <script>
                                        function selectboxChange() {
                                            const select = document.getElementById('Select1');
                                            num = select.selectedIndex;
                                            str = select.options[num].value;
                                            document.getElementById("text2").value = str;
                                        }
                                    </script>
                                </div>
                                <div class="invalid-feedback">
                                    @error('file_name')
                                    <div><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div><small>ファイル名を変更する場合は↓↓↓を変更</small></div>
                                <input type="text" id="text2" name="file_name"
                                    class="form-group form-control @error('file_name') is-invalid @enderror"
                                    value="{{ old('file_name', $projects->count()==1 ? $user->department->documents[0]->name : '')}}">
                                <div class="invalid-feedback">
                                    @error('file')
                                    <div><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="file" name="file"
                                        class="form-control-file @error('file') is-invalid @enderror" required>
                                </div>
                                <div class="form-group" style="margin-bottom:0;">
                                    <button type="submit" class="col-sm-12 btn mybtn">アップロード</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                @if($p <> null)<!--完成図書 -->
                    @if($user->department_id == 3) 
                        <div class="card mx-auto mb-2" style="width: 20rem;">
                            <h5 class="card-title text-center mt-3" style="margin-bottom:0;font-weight:bold">完成図書</h5>
                            <div class="card-body">
                                <form method="POST" action="list\finaldocumentsupload" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id"
                                        class="form-group @error('id') is-invalid @enderror"
                                        value="{{ old('prepareid', $projects->count()==1 ? $projects[0]->id : '') }}">
                                    <div class="invalid-feedback text-center">
                                        @error('id')
                                        <div>
                                            <h6 style="font-weight:bold;">{{ $message }}</h6>
                                        </div>
                                        @enderror
                                        <br>
                                    </div>
                                    @if($projects->count()==1)
                                        <div class="text-center">
                                            <h6 class="p-1" style="font-weight:bold;">プロジェクト:{{ $projects[0]->projectid }}</h6>
                                        </div>
                                    @endif
                                    <div class="invalid-feedback">
                                        @error('file')
                                        <div><small>{{ $message }}</small></div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="file" multiple name="files[]" class="form-control-file" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="col-sm-12 btn mybtn">アップロード</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        <!--　左サイド　-->

        <!--　中央　-->
        <div class="col-sm-4 col-md-8">
            <div class="row">
                <!--project一覧 -->
                <div class="col-md-8">
                    <div class="p-1" style="background-color:#001871;">
                        <a href="/list" style="font-weight:bold;color:white; ">プロジェクト一覧</a>
                    </div>
                    <div class="d-inline-flex align-items-center">
                        <form action ="/list" method="get" class="mt-1 mr-2">                         
                            <input type="text" name="search" style="width:180px" class="form-control" placeholder="検索文字列を入力" onchange="submit(this.form)">            
                        </form>
                        <a class="nav-link" href="/list">全て表示</a>
                        </div>
                    <table class="table table-sm mt-2">
                        <tr>
                            <th style="border: none;font-weight:bold">ID</th>
                            <th style="border: none;font-weight:bold">物件番号</th>
                            <th colspan="3" style="border: none;font-weight:bold">プロジェクトID</th>
                            <th style="border: none;font-weight:bold">機械番号</th>
                            <th style="border: none;font-weight:bold">契約先</th>
                            <th style="border: none;font-weight:bold">納品先</th>
                        </tr>
                        @foreach($projects as $project)
                        <tr>
                            <td>
                            <form action="/list" method="get">
                                    <button type="subumit" class="btn small"
                                        style="padding:0 0;color:blue; font:bold">{{ $project -> id }}</button>
                                    <input type="hidden" name="id" value="{{ $project -> id }}">
                                </form>
                            </td>
                            <td>
                                <div class="wrap-text">{{ $project -> prepareid }}</div>
                            </td>
                            <td>
                            <div class="wrap-text">{{ $project -> projectid }}</div>
                            </td>
                            <td>
                                <form action="/claims/create" method="post">
                                    {{ csrf_field() }}
                                    @if($project -> projectid == null)                                     
                                        <button type="subumit" disabled class="btn mybtn" style="padding:0 10px;"><small>puroject無</small></button>
                                    @elseif($project -> machineid == null)
                                        <button type="subumit" disabled class="btn mybtn" style="padding:0 10px;"><small>機械番号無</small></button>
                                    @else
                                        <button type="subumit" class="btn mybtn" style="padding:0 10px;"><small>Claim&nbsp;</small><span
                                                class="badge badge-danger"><small>{{$project->claims->count()}}</small></span></button>
                                                
                                    @endif
                                    
                                    <input type="hidden" name="project_id" value="{{ $project -> id }}">
                                    <input type="hidden" name="project_name" value="{{ $project -> projectid }}">
                                    <input type="hidden" name="machineid" value="{{ $project ->  machineid }}">
                                </form>
                            </td>
                            <td>
                                <form action="/customer/create" method="post">
                                    {{ csrf_field() }}
                                    <button type="subumit" class="btn mybtn" style="padding:0 10px;"><small>履歴&nbsp;</small><span
                                            class="badge badge-danger"><small>{{$project->customers->count()}}</small></span></button>
                                    <input type="hidden" name="project_id" value="{{ $project -> id }}">
                                </form>
                            </td>
                            <td>
                                <div class="wrap-text">{{ $project -> machineid }}</div>
                            </td>
                            <td>
                                <div class="wrap-text">{{ $project -> customer }}</div>
                            </td>
                            <td>
                                <div class="wrap-text">{{ $project -> enduser }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <!--クレーム一覧 -->
                <div class="col-md-4">
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
                        @if($projects->count() == 1)
                            @foreach($project->claims as $claim)
                            
                                <tr>
                                    <td>
                                        <form action="/claims/create" method="post">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn small" style="padding:0 0;color:blue; font:bold">{{
                                                $claim -> id}}</button>
                                            <input type="hidden" name="claim_id" value="{{ $claim -> id }}">
                                            <input type="hidden" name="project_id" value="{{ $project -> id}}">
                                            <input type="hidden" name="project_name" value="{{$project -> projectid}}">
                                            <input type="hidden" name="machineid" value="{{ $claim -> machineid}}">
                                            <input type="hidden" name="workingday" value="{{ $claim -> workingday }}">
                                            <input type="hidden" name="memo" value="{{ $claim -> memo }}">
                                        </form>
                                    </td>
                                    <td><div class="wrap-text">{{ $claim -> machineid }}</div></td>
                                    <td><div class="wrap-text">{{ $claim -> workingday->format('y/m/d') }}</div></td>
                                    <td><div class="wrap-text">{{ $claim -> memo }}</div></td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="border: none;">
                                        <ui class="dul">
                                            <small>
                                                @foreach($claim->items as $item)
                                                @if($item->branch==null)
                                                <li>
                                                    <a href="{{ asset('storage/projects/'. $project->id . '/claims/' . $claim->id .'/' . $item->name.'.'.$item->extension ) }}">{{$item->name}}</a>
                                                </li>
                                                @else
                                                <li>
                                                    <a href="{{ asset('storage/projects/'. $project->id . '/claims/' . $claim->id .'/' . $item->name.'_'.$item->branch.'.'.$item->extension ) }}">{{$item->name}}</a>
                                                </li>
                                                @endif
                                                @endforeach
                                            <small>
                                        </ui>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <!--　中央　-->

        <!--　右サイド　-->
        <div class="col-sm-4 col-md-2">
            @if($p <> null)
                @if($project->customers->count() > 0)  
                    <div class="p-1" style="background-color:#001871;">
                        <a class="btn" onclick="clickBtn1()"
                            style="font-weight:bold;color:white;padding-top:0;padding-bottom:0;">契約先の遍歴</a>
                    </div>
                    <div id="p1">
                        <table class="table table-sm" style="font-size: 8pt; line-height: 200%; ">
                            <tr>
                                <th>更新日</th>
                                <th>契約先</th>
                                <th>納品先</th>
                            </tr>
                            @foreach($project->customers as $customer)
                            <tr>
                                <td>
                                    <div class="wrap-text">{{ $customer->updateday->format('y/m/d') }}</div>
                                </td>
                                <td>
                                    <div class="wrap-text">{{ $customer->customer }}</div>
                                </td>
                                <td>
                                    <div class="wrap-text">{{ $customer->enduser }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
            
                <div class="ml-2">                     
                        @if($project->finaldocuments->count() > 0)  
                            <h6 class="p-2" style="font-weight:bold;background-color:#001871;color:white;">完成図書</h6>
                            <ui class="list-group list-group-flush">
                                @foreach($project->finaldocuments as $item)                      
                                    <div class="row">    
                                        @if(Auth::user()->department_id == 3)
                                            <form method="POST" action="list/fdelete">
                                            {{ csrf_field() }}
                                                <button type=submit class="btn ml-3 mb-1" name="btn"
                                                    style="background-color:#7EDCC4;color:#001871; font-weight:bold;padding-bottom:0;">削除</button>
                                                <input type="hidden" name="fid" value="{{ $item->id }}">
                                                <input type="hidden" name="fname"
                                                    value="{{'/public/projects/'. $item->project_id . 'finaldocuments//' . $item->name.'_'.$item->branch.'.'.$item->extension }}">
                                            </form>
                                        @endif
                                        <a href="{{ asset('/storage/projects/'. $item->project_id. '/finaldocuments/'. $item->name.'_'.$item->branch.'.'.$item->extension ) }}"
                                            class="ml-3">
                                        <li class="ml-2" style="list-style: none;">{{ $item->name }}</li><a>
                                    </div>
                                @endforeach
                            </ui>
                        @endif             
                </div>
            @endif
            <div class="ml-2">
            @if($p <> null)              
                @foreach($departments as $department)
                    <?php
                        $d_items=$department->items($project->id)->get();                            
                    ?>
                    
                    <ui class="list-group list-group-flush">
                        @foreach($d_items as $key => $item)
                            @if($item->count() >0)
                                @if($key==0)
                                <h6 class="p-2" style="font-weight:bold;background-color:#001871;color:white;">{{$department->name2}}</h6>
                                @endif
                                <div class="row">
                                    @if(Auth::user()->department_id == $item->department_id)
                                        <form method="POST" action="list\fdelete">
                                            {{ csrf_field() }}
                                            <button type=submit class="btn ml-3 mb-1" name="btn"
                                                style="background-color:#7EDCC4;color:#001871; font-weight:bold;padding-bottom:0;">削除</button>
                                                <input type="hidden" name="project_id" value="{{ $projects[0]->id }}">    
                                            <input type="hidden" name="fid" value="{{ $item->id }}">
                                            <input type="hidden" name="fname"
                                                value="{{'/public/projects/'. $projects[0]->id . '/'.$department->id.'/' . $item->name.'_'.$item->branch.'.'.$item->extension }}">
                                        </form>
                                    @endif
                                    <a href="{{ asset('/storage/projects/'. $projects[0]->id . '/'.$department->id. '/' . $item->name.'_'.$item->branch.'.'.$item->extension ) }}"
                                        class="ml-3">
                                        <li class="ml-2" style="list-style: none;">{{ $item->name }}</li>
                                    <a>
                                </div>
                            @endif
                        @endforeach
                    </ui>
                @endforeach
            @endif
            </div>
        </div>
        <!--　右サイド　-->
    </div>
</div>

@endsection