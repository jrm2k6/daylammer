@extends('layouts.layout_base')

@section('content')
    <div id="content-success-subscription">
        <p>Bummer {{$email}}!</p>
        <p>It seems like your confirmation token expired!</p>
        <a href='/resend-confirmation?email={{$email}}'>Resend Confirmation Email</a>
    </div>
@endsection