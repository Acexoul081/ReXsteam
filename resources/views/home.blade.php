@extends('layouts.app')

@section('content')
<div class="container">
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
            @endforeach
        </div>
    @endif
    <div class="row justify-content-center">
        @if(isset($games))
            @foreach($games as $game)
                <a href="{{ route('detail_game', ['id'=>$game->id]); }}" class="card px-0 m-2" style="width: 30rem;">
                    <img class="card-img" src="{{Storage::url($game->cover)}}" alt="thumbnail">
                    <div class="card-img-overlay text-white d-flex flex-column justify-content-end align-items-start">
                        <h4 class="card-title">{{$game->name}}</h4>
                        <h6 class="card-subtitle mb-2">{{$game->category}}</h6>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
</div>
@endsection
