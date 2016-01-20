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
        {!! Form::open(['url' => '/create-password', 'class' => 'login-form']) !!}
        <input type="text" name="email" placeholder="Email">
        <input class="login-password" type="password" name="password" placeholder="Password">
        <input class="login-password" type="password" name="password_confirmation" placeholder="Confirm your password">
        <div class="login-form-buttons">
            <button class="btn waves-effect waves-light btn-large" type="submit" name="action">
                Create password
            </button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection