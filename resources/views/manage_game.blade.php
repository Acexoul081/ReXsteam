@extends('layouts.app')

@section('content')
<div class="container">
    @if (Route::has('add_game'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('add_game') }}">{{ __('Create Game') }}</a>
        </li>
    @endif

</div>
@endsection