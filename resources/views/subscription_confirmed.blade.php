@extends('layouts.layout_base')

@section('content')
    <div id="content-success-subscription">
        <p>Hey {{$email}}!</p>
        <p>All good! You're all set! You should receive your first challenge by email around {{$date_next_email->format('l, jS')}}</p>
    </div>
@endsection