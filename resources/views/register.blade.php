@extends('auth.layouts.default')

@section('title')
    @parent
    Register
@stop

@section('content')

    <h1>Register</h1>

    <form id="form-login" class="form-horizontal" method="POST" action="{{ route('auth.register.post') }}">
        {!! csrf_field() !!}

        <div class="form-group">
            <label class="control-label col-md-4" for="name">Name</label>

            <div class="col-md-8">
                <input type="name" name="name" id="name" value="{{ old('name') }}" class="form-control input-sm">
            </div>
        </div>


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
                <button type="submit" class="btn btn-default">Register</button>
            </div>
        </div>
    </form>

@stop
