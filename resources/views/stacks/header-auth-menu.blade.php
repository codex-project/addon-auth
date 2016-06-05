<div class="switcher">
    <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
            Account <span class="caret"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('codex.auth.login', 'bitbucket') }}">Login with Bitbucket</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('codex.auth.login', 'github') }}">Login with Github</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('codex.auth.logout', 'bitbucket') }}">Logout from Bitbucket</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('codex.auth.logout', 'github') }}">Logout from Github</a></li>

            </li>
        </ul>
    </div>
</div>