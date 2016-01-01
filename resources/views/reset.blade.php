@extends('auth.layouts.default')

@section('title')
    @parent
    Password reset
@stop

@section('content')

    <h1>Password reset</h1>

    <form id="form-login" class="form-horizontal" method="POST" action="{{ route('auth.password.reset.post') }}">
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label class="control-label col-md-4" for="email">Email</label>

            <div class="col-md-8">
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control input-sm">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-4" for="password">Password</label>

            <div class="col-md-8">
                <input type="password" name="password" id="password" class="form-control input-sm">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-4" for="password_confirmation">Confirm password</label>

            <div class="col-md-8">
                <input type="password_confirmation" name="password_confirmation" id="password_confirmation" class="form-control input-sm">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-4 col-md-8">
                <button type="submit" class="btn btn-default">Reset Password</button>
            </div>
        </div>
    </form>

@stop
