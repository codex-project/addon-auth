<c-header-menu-item v-on:click.native="toggleSidenav('auth')" icon="key"></c-header-menu-item>

<c-side-nav ref="sidenav-auth">
    @if(codex('auth')->isLoggedIn())
        <li><a class="subheader">Authorised with</a></li>
        <li>
            <v-collection>
                @foreach(codex('auth')->getDrivers() as $driver)
                    @if(codex('auth')->isLoggedIn($driver) === true)
                        <v-collection-avatar src="{{ codex('auth')->getUser($driver)->getAvatar() }}">
                            <span class="title">{{ codex('auth')->getUser($driver)->getName() }}</span>
                            <p>{{ ucfirst($driver) }}<br>{{ codex('auth')->getUser($driver)->getEmail() }}</p>
                            <a href="{{ route('codex.auth.logout', $driver) }}" slot="secondary">
                                <i class="fa fa-minus-circle fa-lg"></i>
                            </a>
                        </v-collection-avatar>
                    @endif
                @endforeach
            </v-collection>
        </li>
    @endif

    <li><a class="subheader">Available Providers</a></li>
    @foreach(codex('auth')->getDrivers() as $driver)
        @if(codex('auth')->isLoggedIn($driver) === false)
            <li><a href="{{ route('codex.auth.login', $driver) }}"><i class="fa fa-{{ $driver }} fa-lg"></i> {{ ucfirst($driver) }}</a></li>
        @endif
    @endforeach

</c-side-nav>
