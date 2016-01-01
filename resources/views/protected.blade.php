@extends('auth.layouts.default')

@section('content')
    @if(isset($errors))
        @include('auth.partials.errors', ['errors' => $errors])
    @endif

    <h1>Protected</h1>

    <p>Route name: <strong>{{ Route::current()->getName() }}</strong></p>
@stop
