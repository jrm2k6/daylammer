@extends('emails.base')
@section('content_email')
    <tr><td style="color: #4A6D7C; font-weight: bold;padding-bottom: 25px;text-align: center;padding-top: 25px;">Confirm your subscription by clicking on the following</td></tr>
    <tr><td style="text-align: center">
            <a style="text-decoration: none; padding: 8px 8px; color: #4A6D7C; font-weight: bold; border:2px solid #4A6D7C;" href={{URL::to('/confirm?token='.$confirmation_token)}}>Confirm email</a>
    </td></tr>
@endsection
