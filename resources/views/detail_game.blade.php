@extends('layouts.app')

@section('content')
<div>
    <div>
        <video src="{{Storage::url($game->trailer)}}" controls></video>
    </div>
    <div>
        <img src="{{Storage::url($game->cover)}}" alt="">
        <div>
            <div>{{$game->name}}</div>
            <div>
                {{$game->description}}
            </div>
            <div>
                <b>Genre</b> : {{$game->category}}
                <b>Release Date</b> : {{$game->created_at}}
                <b>Developer</b> : {{$game->developer}}
                <b>Publisher</b> : {{$game->publisher}}
            </div>
        </div>
    </div>
</div>
<div>
    Buy {{$game->name}}
    <div>
        Rp.{{$game->price}}
        <a class="dropdown-item" href="{{ route('cart_add') }}"
            onclick="event.preventDefault();
                document.getElementById('cart-form').submit();">
            {{ __('Add To Cart') }}
        </a>

        <form id="cart-form" action="{{ route('cart_add') }}" method="POST" class="d-none">
            @csrf
            <input type="hidden" name="game" value="{{$game->id}}">
        </form>
    </div>
</div>
<div>
    ABOUT THIS GAME
    <hr>
    {{$game->long_description}}
</div>

@endsection