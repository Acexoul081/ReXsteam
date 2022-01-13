@extends('layouts.app')

@php
    $total_price = 0;
    if(isset($cart)){
        foreach($cart as $item){
            $total_price+=$item['price'];
        }
    }
    
@endphp
@section('content')

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            @foreach ($errors->all() as $error)
                {{$error}}
                @endforeach
        </div>  
    @endif

    @if(isset($cart))
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
        <div>
            Total Price: Rp. {{$total_price}}
        </div>
        <form action="{{ route('add_transaction') }}" method="GET" class="">
            <button type="submit">Checkout</button>
        </form>
    @endif
@endsection