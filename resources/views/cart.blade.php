@extends('layouts.app')

@section('content')
    @foreach($cart as $game)
        <div>
            <div>
                <img src="{{Storage::url($game['cover'])}}" alt="">
            </div>
            <div>
                <div>
                    {{$game['name']}}, {{$game['category']}}
                </div>
                <div>
                    {{$game['price']}}
                </div>
            </div>
            <div>
                <form action="{{ route('cart_delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{$game['id']}}">
                    <button type="submit" class="btn btn-primary">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @endforeach
    <form action="{{ route('add_transaction') }}" method="GET" class="">
        <button type="submit">Checkout</button>
    </form>
@endsection