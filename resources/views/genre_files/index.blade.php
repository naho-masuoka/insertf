@extends('layouts.app')
@section('content') 
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2>登録書類一覧</h2>
        </div>
        <div>
            <a href="/files/create/0" class="btn mybtn">ジャンル作成</a>
            <a href="/internal" class="btn mybtn">戻る</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <!--main -->
        <div class="col-md-8 col-sm-10">
            @foreach($genre_files as $f)
                <ui class="list-group list-group-flush">       
                    <div class="align-items-center row mb-2">
                    @if($f->department_id == Auth::user()->department_id)               
                        <li class="m-2" style="list-style: none;"><a href="files/create/{{$f->id}}" class="btn mybtn">編集</a></li>
                    @else
                        <li class="m-2" style="list-style: none;"><a href="#" class="btn" style="background-color:#F98866;color:white;font-weight:bold">不可</a></li>
                    @endif
                        <li class="m-2" style="list-style: none;">                            
                            <form method="post" action="{{ route('genre_file.putindex') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="genre_file_id" value="{{$f->id}}">
                                <input type="hidden" name="name" value="{{$f->name}}">
                                <input type="hidden" name="department_id" value="{{$f->department_id}}">
                                @if($f->department_id == Auth::user()->department_id)
                                    <button type="submit" class="btn mybtn" style="width:100px;">公開部署
                                @else
                                <input type="hidden" name="d_id" value="{{$f->department_id}}">
                                    <button type="submit" class="btn mybtn" style="width:100px;background-color:#F98866;color:white;font-weight:bold">{{ \App\Department::find($f->department_id)->name2 }}
                                @endif
                            </form>
                        </li>
                        @if($f->name == $request->name)
                            <li class="m-2" style="list-style: none;font-weight:bold;font-size:20px;color:red;">{{$f->sort_no}}</li>   
                            <li class="m-2" style="list-style: none;font-weight:bold;font-size:20px;color:red;">{{$f->name}}</li>
                        @else                    
                            <li class="m-2" style="list-style: none;">{{$f->sort_no}}</li>   
                            <li class="m-2" style="list-style: none;">{{$f->name}}</li>
                        @endif            
                    </div>
                </ul>
            @endforeach
        </div>
        <!--right -->
        <div class="col-md-2 col-sm-10 d-none d-md-block">
            <div class="card mb-2" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">書類公開部署:{{$request->name}}</h5>
                    <hr>
                    @if(isset($departments))                        
                        @foreach($departments as $d) 
                        @if($request->has('d_id'))
                            {{$d->name2}} 
                        @else                         
                            <form method="post" action = "{{ route('Genre_file.store_destroy') }}" class="form-inline mb-1">
                                {{ csrf_field() }}
                                <button type="submit" class="btn mybtn mr-2" style="width:100px;">閲覧中</button>
                                <input type="hidden" name="is_select" value=2>
                                <input type="hidden" name="genre_file_id" value="{{$request->genre_file_id}}">    
                                <input type="hidden" name="department_id" value="{{$d->departmentid}}">
                                {{$d->name2}}                            
                            </form>
                        @endif
                        
                        @endforeach
                    @endif
                        @if(isset($undepartments))
                            @foreach($undepartments as $d)
                            @if($request->has('d_id'))
                            @else
                                @if($d->departmentid <> Auth::user()->department_id)        
                                    <form method="post" action = "{{ route('Genre_file.store_destroy') }}" class="form-inline mb-1">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn mr-2" style="width:100px;background-color:#F98866;color:white;font-weight:bold">閲覧許可</button>
                                        <input type="hidden" name="is_select" value=1>
                                        <input type="hidden" name="genre_file_id" value="{{$request->genre_file_id}}">
                                        <input type="hidden" name="department_id" value="{{$d->id}}">                                    
                                        {{$d->name2}}                                
                                    </form>
                                @endif
                            @endif                             
                            @endforeach
                    @endif
                </div>
            </div>            
        </div>
        
    </div>
</div>
@endsection