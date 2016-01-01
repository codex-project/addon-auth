@extends('auth.layouts.default')

@if(Auth::check())
    @set('user', Auth::user()->load(['roles']))
    {{-- ->toArray() --}}
@endif

@section('content')
    @if(isset($errors))
        @include('auth.partials.errors', ['errors' => $errors])
    @endif

    <h1>Overview</h1>


    @if(Auth::check())
        <p>Welcome {{ $user['name'] }}.</p>
        <?php
        //$roles = Auth::user()->roles();
        //$roles->sync([2]);


        $user = Auth::user();
            _d(Tank::hasAllPermissions('super_admin', 'somestuf'));
       // $user->addPermission('auth.protected2')->save();
            //Tank::getPermissions()->store(['name' => 'Auth Protected 2', 'description' => 'asdf', 'slug' => 'auth.protected2']);
        foreach ( app('tank')->getUserRepository()->with('roles')->getAll() as $user )
        {
            _d([
                'id' => $user->id,
                'email' => $user->email,
                'user can post_news'      => $user->can('post_news'),
                'user cannot super_admin' => $user->cannot('super_admin'),
                'gate allows post_news'   => Gate::forUser($user)->allows('post_news'),
                'gate allows super_admin' => Gate::forUser($user)->allows('super_admin')
            ]);
        }
        #$role = app('Laradic\Tank\Models\Role');
        #$permission = app('Laradic\Tank\Models\Permission');




        ?>
    @else
        <p>You are not logged in.</p>
    @endif
@stop

@push('scripts')
<script>
    $(function () {
    });
</script>
@endpush
