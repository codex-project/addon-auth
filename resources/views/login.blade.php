@extends('codex::layouts.default')

@section('title')
    @parent
    :: Login
@stop

@section('pageTitle', 'Login')

@section('bodyClass', 'page-loading page-header-fixed page-footer-fixed page-edged page-sidebar-closed page-sidebar-hide')

@section('page-header-sidebar-toggle', ' ')

@section('content')

    <form id="form-login" class="form-horizontal" method="POST" action="{{ URL::current() }}">
        {!! csrf_field() !!}

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
            <div class="col-md-offset-4 col-md-8">
                <label for="remember"><input type="checkbox" name="remember" id="remember"> Remember Me</label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-4 col-md-8">
                <button type="submit" class="btn btn-default">Login</button>
                <button id="auto-login" type="button" class="btn btn-primary">Auto fill &amp; login</button>
            </div>
        </div>
    </form>

@stop

@push('scripts')
<script>
    $(function(){
        $('#auto-login').on('click', function(e){
            e.preventDefault();
            $('#email').val('admin@radic.nl');
            $('#password').val('test1234');
            $('#form-login').submit();
        })
    });
</script>
@endpush
