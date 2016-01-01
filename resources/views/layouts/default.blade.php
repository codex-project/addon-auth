<!DOCTYPE html>
<html lang="en">
<head>

    @minify('html')
    <meta charset="UTF-8">
    <title>
        Auth Demo
        @section('title')
            ::
        @show
    </title>

    {{-- Layout style definitions --}}
    @section('default_styles')
        <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/superhero/bootstrap.min.css" rel="stylesheet">
    @show


    @endminify
    {{-- View style definitions --}}
    @stack('styles')
</head>
<body>
@minify('html')
{{-- Top navigation --}}
@section('navigation')

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    Auth
                </a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{ route('auth.index') }}">Overview</a></li>
                    <li><a href="{{ route('auth.protected') }}">Protected</a></li>
                    <li><a href="{{ route('auth.protected2') }}">Protected2</a></li>
                    @if(Auth::check())
                        <li><a href="{{ route('auth.logout') }}">Logout</a></li>
                    @else
                        <li><a href="{{ route('auth.login') }}">Login</a></li>
                        <li><a href="{{ route('auth.register') }}">Register</a></li>
                        <li><a href="{{ route('auth.password.forgot') }}">Forgot password</a></li>
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ app('caffeinated.dev.frontpage')->getRoute()->uri() }}">Back</a></li>
                </ul>
            </div>
        </div>
    </nav>

@show

{{-- Content (container adjustable) --}}
<div class="@yield('containerClass', 'container')">

    @section('errors')
        @if(isset($errors))
            @include('auth.partials.errors')
        @endif
    @show

    @section('content')

    @show
</div>
@endminify


@minify('html')
{{-- Layout script definitions --}}
@section('default_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@show
@endminify

{{-- View script definitions --}}
@stack('scripts')

</body>
</html>
