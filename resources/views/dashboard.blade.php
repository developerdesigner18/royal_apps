@extends('layouts.user')
@section('title','DashBoard')
@section('pagename','DashBoard')
@section('body')
    <h5 class="card-title">Hello, {{($user['first_name'])}} {{$user['last_name']}}</h5>
    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor orci eu metus facilisis
        vestibulum. Integer pellentesque sapien vitae elit malesuada, eu eleifend nisi finibus. Suspendisse malesuada
        erat ut mi posuere, vel vestibulum lorem dapibus.</p>
@endsection
