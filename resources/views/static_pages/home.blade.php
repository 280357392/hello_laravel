@extends('layouts.default')
@section('title','主页')
@section('content')
    <div class="jumbotron">
        <h1>Hello Laravel</h1>
        <p class="lead">
            你现在所看到的是 Laravel 项目主页。
        </p>
        <p>
            <a class="btn btn-lg btn-success" href="{{route('users.create')}}" role="button">现在注册</a>
        </p>
    </div>
@stop