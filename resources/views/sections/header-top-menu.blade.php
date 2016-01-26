@push('header-top-menu')
<li class="dropdown dropdown-auth">
    <a href="javascript:;" class="dropdown-toggle tooltip-toggle" data-title="Authentication" data-placement="left" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <i class="fa fa-key"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-packadic dropdown-menu-inverse dropdown-menu-right">

        @foreach($auths as $provider => $data)
            @if($data === false)
                <a href="{{ route('codex.hooks.auth.social.login', compact('provider')) }}" class="dropdown-item"><i class="fa fa-{{ $provider }}"></i> {{ ucfirst($provider) }} login </a>
            @else
                <a href="{{ route('codex.hooks.auth.social.logout', compact('provider')) }}" class="dropdown-item">
                    <img alt="" class="img-circle avatar pull-right" src="{{ $data->getAvatar() }}"/>
                    <i class="fa fa-{{ $provider }}"></i>
                    logout {{ $data->getName() }}
                </a>

            @endif
        @endforeach

    </ul>
</li>
@endpush
