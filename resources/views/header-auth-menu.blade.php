    <ul class="dropdown-nav codex-auth-switcher">
        <li class="dropdown">
            <a class="dropdown-toggle" type="button" id="header-dropdown-auth" data-toggle="dropdown" aria-expanded="true">
                Account <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="header-dropdown-auth">
                @foreach(codex('auth')->getDrivers() as $driver)
                    @if(codex('auth')->isLoggedIn($driver) === false)
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="{{ route('codex.auth.login', $driver) }}">
                                <i class="switcher-icon switcher-icon-{{ $driver }}"></i>
                                <span class="switcher-title">Login with {{ ucfirst($driver) }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
                @foreach(codex('auth')->getDrivers() as $driver)
                    @if(codex('auth')->isLoggedIn($driver) === true)
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="{{ route('codex.auth.logout', $driver) }}">
                                <img class="switcher-avatar" src="{{ codex('auth')->getUser($driver)->getAvatar() }}"/>
                                <span class="switcher-title">Logout from {{ ucfirst($driver) }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li>
    </ul>
