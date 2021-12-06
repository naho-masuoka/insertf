@extends('layouts.app')
@section('content') 
<div class="container col-md-6 col-xs-10">
    @if(isset($msg))
        <div class="alert alert-dismissible fade show" role="alert" style="background-color:#6b778d;color:white;">
            {{ $msg }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>    
        </div>
    @endif
    <div class="row justify-content-end">
        @if($id == 0)
            <a href="/internal" class="btn mybtn m-3">
        @else
            <a href="/files" class="btn mybtn m-3">
        @endif
        戻る</a>
    </div>
    <form method="POST" action="/files/store">
        {{ csrf_field() }}
        <div class="form-group"> 
            <h5>部署名:{{ Auth::user()->department->name2 }}</h5>         
            <input type="hidden" name="id" class="form-control" value="{{ old('id', $id==0 ? '' :  $id) }}">
            <input type="hidden" name="department_id" class="form-control"}}" value="{{ Auth::user()->department->name2 }}">  
        </div>
        <div class="form-group">     
            <label>表示順</label>
            <input type="number" name="sort_no" class="form-control" value="{{ old('sort_no', isset($genre_file[0]->sort_no) ? $count: $count) }}">  
        </div>
        <div class="form-group">     
            <label>標題名</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', isset($genre_file[0]->name) ? $genre_file[0]->name: '') }}">  
        </div>
        <div class="form-group">
            @if($id==0)
                <button type="submit" class="form-control btn mybtn mt-2">作成</button>
            @else
                <button type="submit" class="form-control btn mybtn mt-2">上書保存</button>
            @endif
        </div>
    </form>     
</div>
@endsection