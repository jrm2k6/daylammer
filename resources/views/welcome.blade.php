@extends('layouts.layout_base')

@section('content')
<div id="content">
    <div id="header">
        <div class="header-title">
            <h1>Daylammer</h1>
        </div>
        <div class="header-content">
            <p>Simple newsletter for r/dailyprogrammer challenges!</p>
            <p>Learning how to code? Keeping your skills sharp? Get challenges directly to your inbox!</p>
        </div>
    </div>
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
        {!! Form::open(['url' => '/subscribe', 'class' => 'subscribe-form']) !!}
            <p class="description-field">Enter your email</p>
            <input id="email" type="text" name="email">
            <p class="description-field">Select when you want to receive your challenges by email</p>
            <div class="frequency-selection">
                <p>
                    <input class="with-gap frequency-selection-radio" name="frequency" type="radio" id="new-challenge"  />
                    <label for="new-challenge">Every challenge</label>
                </p>
                <p>
                    <input class="with-gap frequency-selection-radio" name="frequency" type="radio" id="weekly"  />
                    <label for="weekly">Weekly</label>
                </p>
                <input id="frequency" name="frequency_hidden" type="hidden">
            </div>
        <p class="description-field">Select the level of difficulty for the challenges you want to receive</p>
            <div class="difficulty-selection">
                <p>
                    <input type="checkbox" class="filled-in" id="difficulty-easy" name="difficulty_easy"/>
                    <label for="difficulty-easy">Easy</label>
                </p>
                <p>
                    <input type="checkbox" class="filled-in" id="difficulty-moderate" name="difficulty_moderate"/>
                    <label for="difficulty-moderate">Moderate</label>
                </p>
                <p>
                    <input type="checkbox" class="filled-in" id="difficulty-hard" name="difficulty_hard"/>
                    <label for="difficulty-hard">Hard</label>
                </p>

                <p>
                    <input type="checkbox" class="filled-in" id="difficulty-all" name="difficulty_all" checked="checked"/>
                    <label for="difficulty-all">All</label>
                </p>
            </div>
            <button class="btn waves-effect waves-light btn-large" type="submit" name="action">Subscribe
                <i class="material-icons right">send</i>
            </button>
        {!! Form::close() !!}
    </div>
</div>
@endsection