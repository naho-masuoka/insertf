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
        <a href="/list" class="form-group btn mybtn m-3">戻る</a>
    </div>
    <form method="POST" action="/user/update">
        {{ csrf_field() }}    
        <div class="form-group">    
            <input type="hidden" name="id" class="form-control" value="{{ Auth::user()->id }}">      
            <label>お名前</label>
            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name  }}">             
        </div>
        <div class="form-group">
            <label>email</label>
            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email  }}">
        </div>
        <div class="form-group">
            <label>部署1</label>
            <select id="Select1" name="department_id" class="form-group form-control">        
                @foreach($departments as $department)  
                    <option value="{{ $department->id }}">{{ $department->name1 .' '. $department->name2}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="form-control btn mybtn mt-2">更新</button>
        </div>
    </form>     
</div>

@endsection