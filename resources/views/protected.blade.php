@extends('codex::layouts.codex-base')

@push('header')
    @section('menu-projects')
        {!! $codex->menus->get('projects')->render() !!}
    @show
@endpush


@push('content')
<div class="text-center">
    <h1>{{ config('codex-auth.error-page.title') }}</h1>
    <p>{{ config('codex-auth.error-page.text') }}</p>
    <a href="javascript:history.back(2);">Go back</a>
</div>
@endpush
