<div class="small-header">
    <h5>Daylammer</h5>
    @if (Auth::user())
        <div class="header-logout">
            <a href="/logout">Logout</a>
        </div>
    @endif
</div>