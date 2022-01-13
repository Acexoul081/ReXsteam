@extends('layouts.app')

@section('content')
<div>
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            @foreach ($errors->all() as $error)
                {{$error}}
            @endforeach
        </div>
    @endif
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
@if(!isset($user_own) || $user_own != true)
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
@endif

<div>
    ABOUT THIS GAME
    <hr>
    {{$game->long_description}}
</div>

@endsection