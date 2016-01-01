@extends('auth.layouts.default')

@section('title')
    @parent
    Password reset
@stop

@section('content')

    <h1>Password reset</h1>

    <form id="form-login" class="form-horizontal" method="POST" action="{{ route('auth.password.forgot.post') }}">
        {!! csrf_field() !!}

        <div class="form-group">
            <label class="control-label col-md-4" for="email">Email</label>

            <div class="col-md-8">
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control input-sm">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-4 col-md-8">
                <button type="submit" class="btn btn-default">Send Password Reset Link</button>
            </div>
        </div>
    </form>

@stop
