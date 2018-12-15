@extends('layouts.app')
@section('title', '警告')
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">警告</div>
    <div class="panel-body text-center">
        <h1>請驗證信箱</h1>
        <a class="btn btn-primary" href="{{ route('email_verification.send') }}">重新傳送驗證信</a>
    </div>
</div>
@endsection