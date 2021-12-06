<?php
    $did=\App\Department::find($request->department_id);
?>
@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <!--nav-->
    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            <div>
                <h2><i class="far fa-file-alt mr-2"></i>{{ $did->name2}}資料</i></h2>
            </div>
        </div>
    </div>
    <!--/nav-->
    <div class="row">
        <!--左サイト-->
        <div class="col-md-3 d-none d-lg-block">
        <div class="mx-auto mb-2" style="width: 20rem;">
                <h5 class="card-title text-center mt-3" style="margin-bottom:0;font-weight:bold;">他部署情報</h5>
                    @foreach($departments as $key => $d)
                    <ul id="accordion_menu">
                        <li>
                            <a data-toggle="collapse" href="#menu{{$key}}" aria-controls="#menu{{$key}}" aria-expanded="false">
                                <div class="d-flex align-items-center">    
                                    <div>{{$d->name2}}</div>
                                    @if($d->genre_fils->count() !=0 )
                                    <div><span class="badge badge-warning ml-2">{{$d->genre_fils->count()}}</span></div>
                                    @endif
                                </div>
                            </a>
                        </li>
                        <ul>
                        
                        <ul id="menu{{$key}}" class="collapse" data-parent="#accordion_menu">
                            <div>
                                @if($d->genre_fils->count() !=0 )
                                    <form method="post" action ="/otherinternal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="department_id" value="{{$d->id}}">
                                        <button type="submit" class="btn btn-link collapsed"><li class="list-item" style="font-weight:bold;list-style:none;">表示</li></button>
                                    </form>
                                @endif
                            </div> 
                            @foreach($d->genre_fils as $f)
                            <div class="d-flex justify-content-left align-items-center">
                                   
                                <div class="ml-2">{{$f->name}}</div>
                                    @if($f->is_viewings() == false)                                         
                                        <div>                                            
                                            <form method="post">
                                                <button type="button" class="btn btn-link collapsed text-left ml-2">←閲覧許可申請</button>
                                            </form>
                                        </div>                                    
                                    @endif
                                </div>   
                            @endforeach
                        </ul>                        
                    </ul>
                    @endforeach
                </ul>
            </div>
        </div>
        <!--/左サイト-->

        <!--Mainサイト-->
        <div class="col-sm-4 col-md-8">
            <!--/PCサイト-->
            <div class="d-none d-md-block">
                <ul class="nav nav-tabs" role="tablist">
                    @foreach($genre_files as $key => $f)
                        @foreach($f->viewings as $d)                            
                            <li class="nav-item">
                                @if($key == 0)
                                <a class="nav-link active" id="item{{$key}}-tab" data-toggle="tab" href="#item{{$key}}"
                                    role="tab" aria-controls="item{{$key}}" aria-selected="true"
                                    style="font-size:15px;font-weight:bold;">
                                @else
                                    <a class="nav-link" id="item{{$key}}-tab" data-toggle="tab" href="#item{{$key}}"
                                        role="tab" aria-controls="item{{$key}}" aria-selected="true"
                                        style="font-size:15px;font-weight:bold;">
                                @endif
                                {{$f->name}}
                                </a>
                            </li>
                            @endforeach 
                        @endforeach 
                </ul>

                <div class="tab-content">
                    @foreach($genre_files as $key => $f)
                        @if($key == 0)
                        <div class="tab-pane fade show active" id="item{{$key}}" role="tabpanel"
                            aria-labelledby="item{{$key}}-tab">
                        @else
                            <div class="tab-pane fade show" id="item{{$key}}" role="tabpanel"
                                aria-labelledby="item{{$key}}-tab">
                        @endif
                        <ul>
                            @foreach($f->files as $df)
                            <div class="row">
                                <li class="mr-3">
                                    <a
                                        href="{{ asset('/storage/files/'. $df->genre_file_id . '/' . $df->name.'_'.$df->branch .'.'.$df->extension ) }}">{{$df->name}}</a>
                                </li>
                                <li class="ml-3" style="list-style: none;">
                                    {{$df->created_at->format('y/m/d')}}
                                </li>
                            </div>
                            @endforeach
                        </ul>
                    </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!--/モバイルサイト-->
        <div class="container d-block d-md-none">
            <form method="get" action="/internal">
                <select name="sfile_id" class="form-group form-control col-md-3" onchange="submit(this.form)">
                    @foreach($genre_files as $f)
                    @if($f->department_id == Auth::user()->department_id)
                    @if(Session::has('file_id'))
                    @if(session('file_id') == $f->id)
                    <option value="{{ $f->id }}" selected>{{ $f->name }}</option>
                    @else
                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                    @endif
                    @else
                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                    @endif
                    @endif
                    @endforeach
                </select>
            </form>
            <script type="text/javascript">
                $(function () {
                    $("#submit_select").change(function () {
                        $("#submit_form").submit();
                    });
                });
            </script>
            <ul>
                @foreach($genre_files as $f)
                @if($f->id == Session('file_id'))
                @foreach($f->files as $df)
                @if($df->id == session('file_id'))
                <div class="row">
                    <li class="mr-3" style="list-style:none;">
                        <a
                            href="{{ asset('/storage/files/'. $df->genre_file_id . '/' . $df->name.'_'.$df->branch .'.'.$df->extension ) }}">{{$df->name}}</a>
                    </li>
                    <li class="ml-3" style="list-style: none;">
                        {{$df->created_at->format('y/m/d')}}
                    </li>
                </div>
                @endif
                @endforeach
                @endif
                @endforeach
            </ul>
            <div>
                <!--/Mainサイト-->   
                    
            </div>
            </div>
@endsection