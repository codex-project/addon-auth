@extends(codex()->view('layouts.base'))

@push('header')
@section('menu-projects')
    {!! $codex->projects->renderMenu() !!}
@show
@endpush


@section('content')
<div class="text-center">
    <h1>Success</h1>
    <p>You are now logged in</p>
    <a href="{{ route('codex.index') }}">Continue</a>
</div>
@stop

@section('breadcrumb')

@stop