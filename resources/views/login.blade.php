@extends('layouts.layout_base')
@section('content')
    @include('small-header')
    @if (count($errors) > 0)
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div id="container">
        {!! Form::open(['url' => '/login', 'class' => 'login-form']) !!}
            <input type="text" name="email" placeholder="Email">
            <input class="login-password" type="password" name="password" placeholder="Password">
            <div class="already-registered">
                <a href="/create-password">I am already registered but I don't have a password!</a>
            </div>
            <div class="login-form-buttons">
                <button class="btn waves-effect waves-light btn-large" type="submit" name="action">Login
                </button>
                <button class="btn waves-effect waves-light btn-large register-btn" type="button" name="action">
                    Register
                </button>
            </div>
        {!! Form::close() !!}
    </div>

@endsection