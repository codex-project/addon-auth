@push('header-actions-right')
<div class="btn-group">
    <a href="#" type="button" data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle btn btn-primary btn-sm">
        @yield('user-name')User
    </a>

    <div class="dropdown-menu">
        <a href="{{ route('codex.hooks.auth.login') }}" class="dropdown-item">Login</a>
    </div>
</div>
@endpush
