@extends('emails.base')
@section('content_email')
    <tr>
        <td style="color: #888888; font-weight: bold;padding-bottom: 25px;text-align: center;padding-top: 25px;">Time for a new challenge from reddit/r/dailyprogrammer</td>
    </tr>
    @foreach($challenges as $challenge)
        <tr>
            <td style="background-color:
                    @if ($challenge->difficulty == 'easy') #3A5F0B
                    @elseif ($challenge->difficulty == 'intermediate') #FF9900
                    @else #CC0000
                    @endif
            ; color: #FFFFFF; font-size: 20px; font-weight: bold; height: 35px; padding-left: 20px; text-transform: uppercase;">{{$challenge->difficulty}}</td>
        </tr>
        <tr><td style="text-align: center; padding-bottom: 10px; font-weight: bold; font-size: 20px;">{{$challenge->title}}</td></tr>
        <tr>
            <td style="color: #333333; max-width: 200px;  white-space: pre-wrap;">
                {!! $challenge->markdown_content !!}
            </td>
        </tr>
        <tr><td style="text-align: center; padding-bottom: 20px;">
                <a style="text-decoration: none; padding: 8px 8px; color: #4A6D7C; font-weight: bold; border:2px solid #4A6D7C;" href="{{$challenge->url}}">View on Reddit</a>
        </td></tr>
    @endforeach
@endsection


