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
    <div id="container">
        <div class="subscribe-form">
            <p class="description-field">Enter your email</p>
            <input id="email" type="text">
            <p class="description-field">Select when you want to receive your challenges by email</p>
            <div class="frequency-selection">
                <p>
                    <input class="with-gap frequency-selection-radio" name="frequency" type="radio" id="new-challenge"  />
                    <label for="new-challenge">Day a new challenge is up</label>
                </p>
                <p>
                    <input class="with-gap frequency-selection-radio" name="frequency" type="radio" id="weekly"  />
                    <label for="weekly">Weekly</label>
                </p>
            </div>
            <button class="btn waves-effect waves-light btn-large" type="submit" name="action">Subscribe
                <i class="material-icons right">send</i>
            </button>
        </div>
    </div>
</div>
@endsection