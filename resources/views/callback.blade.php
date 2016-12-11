@extends(codex()->view('layouts.default'))


@section('body')
<div class="text-sm-center">
    <h1>Success</h1>
    <p>You are now logged in</p>
    <a href="{{ route('codex.document') }}">Continue</a>
</div>
@stop
