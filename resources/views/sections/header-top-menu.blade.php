@push('header-top-menu')
<li class="dropdown dropdown-user dropdown-dark">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <span class="username username-hide-on-mobile">
            @if(isset($currentUser))
                {{ $currentUser->getName() }}
            @else
                Account
            @endif
        </span>

        @if(isset($currentUser))
        <img alt="" class="img-circle" src="{{ $currentUser->getAvatar() }}"/>
        @endif

    </a>
    <ul class="dropdown-menu dropdown-menu-packadic dropdown-menu-inverse dropdown-menu-right">
        <a href="{{ route('codex.hooks.auth.login') }}" class="dropdown-item"><i class="fa fa-key"></i> Authorize </a>

        @if(isset($currentUser))
        <a href="#" class="dropdown-item"><i class="fa fa-user"></i> My Profile </a>
        @else
            
        @endif

    </ul>
</li>
@endpush
