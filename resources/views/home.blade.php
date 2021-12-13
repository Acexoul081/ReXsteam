@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach($games as $game)
            <div class="card">
                <img class="card-img" src="{{Storage::url($game->cover)}}" alt="thumbnail">
                <div class="card-img-overlay text-white d-flex flex-column justify-content-end align-items-start">
                    <h4 class="card-title">{{$game->name}}</h4>
                    <h6 class="card-subtitle mb-2">{{$game->category}}</h6>
                </div>
            </div>
        @endforeach
        <!-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection
