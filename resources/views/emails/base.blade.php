<table border="0" cellpadding="0" cellspacing="0" style="margin-left: 15%; width: 600px;font-family: 'Roboto', sans-serif;">
    <tr style="width: 100%;height: 70px;text-align: center;background-color: #4A6D7C;font-weight: 300;font-size: 2.2rem;color: white;">
        <td>Daylammer</td>
    </tr>

    @yield('content_email')

    <tr>
        <td style="padding-top: 60px;">
            <table border="0" cellpadding="0" cellspacing="0"
                   style="width: 100%;text-align: center;background-color: #4A6D7C;height: 60px; font-size: 0.6rem;color: white;">
                <td>You are receiving this email because you have subscribed to daylammer.jeremydagorn.com</td>
                <tr><td><a href="{{URL::to('/unsubscribe?email='.$email)}}">Unsubscribe</a> | <a href="http://www.jeremydagorn.com">Made by Jeremy Dagorn</a></td></tr>
            </table>
        </td>
    </tr>

</table>