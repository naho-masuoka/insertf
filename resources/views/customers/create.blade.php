
@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-1">
        </div>
        <div class="col-sm-4 col-md-5">
            @if(isset($msg))
                <div class="alert alert-dismissible fade show" role="alert" style="background-color:#6b778d;color:white;">
                    {{ $msg }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>    
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center">
                <p style="font-weight:bold">物件番号:{{$project[0]->prepareid}}</p>
                <p style="font-weight:bold">プロジェクト:{{$project[0]->projectid}}</p>
                <a href="/list/?id={{ session('id')}}" class="btn mybtn m-3">戻る</a>
            </div>
            <form method="POST" action="/customer/store">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>ID</label>
                    <input type="text" name="id" class="form-control" value="{{ old('id',  isset($customer->id) ? $customer->id : '') }}">                        
                    <input type="hidden" name="project_id" class="form-control" value="{{ old('project_id',  isset($project[0]->id) ? $project[0]->id : '') }}"> 
                </div>
                <div class="form-group">            
                    <label>契約先</label>
                    <input type="text" name="customer" class="form-control" value="{{ old('customer', isset($customer->customer) ?$customer->customer : '') }}">   
                </div>
                <div class="form-group">
                    <label>納品先</label>
                    <input type="text" name="enduser" class="form-control" value="{{ old('enduser', isset($customer->enduser) ? $customer->enduser : '') }}">     
                </div>
                <div class="form-group">
                    <label>更新日</label>
                    <input type="date" name="updateday" class="form-control" value="{{ $updateday }}">   
                </div>
                <div class="form-group">
                    <button type="button" id ="customer_button" onclick="submit();" class="form-control btn mybtn mt-2">登録</button>

                </div>
            </form>     
        </div>
        
        <div class="col-md-1">
        </div>
        <div class="col-md-5">
            <div class="p-1" style="background-color:#001871;">
                <a class="btn"
                    style="font-weight:bold;color:white;padding-top:0;padding-bottom:0;">契約先の遍歴</a>
            </div>
            <div id="p1">
                <table class="table table-sm">
                    <tr>
                        <th>ID</th>
                        <th>更新日</th>
                        <th>契約先</th>
                        <th>納品先</th>
                    </tr>
                    @foreach($customers as $c)
                    <tr>
                        <td>
                            <div class="wrap-text">
                            <form action="/customer/edit" method="post">
                                {{ csrf_field() }}                                    
                                <button type="subumit" class="btn btn-link" style="padding:0 10px;">{{ $c->id }}</button>
                                <input type="hidden" name="id" value="{{ $c -> id }}">
                                <input type="hidden" name="project_id" value="{{ $c->project_id }}">
                                <input type="hidden" name="customer" value="{{ $c -> customer}}">
                                <input type="hidden" name="enduser" value="{{ $c-> enduser }}">
                            </form>
                            </div>
                        </td>
                        
                        <td>
                            <div class="wrap-text">{{ $c->updateday->format('y/m/d') }}</div>
                        </td>
                        <td>
                            <div class="wrap-text">{{ $c->customer }}</div>
                        </td>
                        <td>
                            <div class="wrap-text">{{ $c->enduser }}</div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
</div>

@endsection