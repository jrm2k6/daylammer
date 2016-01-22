@extends('layouts.layout_base')
@section('content')
    @include('small-header')
    <div id="content">
        <div class="settings-container">
            <h4> Challenge difficulties </h4>
            <div class="challenge-difficulty-settings">
                @foreach($difficulties as $difficulty)
                    <div class="settings-item z-depth-3 hoverable">
                        <div class="settings-text">{{$difficulty->name}}</div>
                        <div class="choose-badge  @if($difficulty->selected) selected @endif"
                             data-difficulty-short-id={{$difficulty->id}}
                        >
                            <i class="material-icons">done</i>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="settings-btns">
                <button class="update-difficulty-btn btn waves-effect waves-light disabled" type="button">Update Difficulties</button>
            </div>
        </div>

        <div class="settings-container">
            <h4> Email frequency </h4>
            <div class="email-frequency-settings">
                @foreach($frequencies as $frequency)
                    <div class="settings-item z-depth-3 hoverable">
                        <div class="settings-text">{{$frequency->name}}</div>
                        <div class="{{$frequency->short_name}}-badge choose-badge @if($frequency->selected) selected @endif"
                            data-frequency-short-name={{$frequency->short_name}}
                        >
                            <i class="material-icons">done</i>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="settings-btns">
                <button class="update-frequency-btn btn waves-effect waves-light disabled" type="button">Update Frequency</button>
            </div>
        </div>
    </div>
@endsection
