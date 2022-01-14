@extends('layouts.app')

@php
    $total_price = 0;
    foreach($cart as $item){
        $total_price+=$item['price'];
    }
@endphp

@section('content')
    <div>
        Transaction ID: {{$header->id}}
    </div>
    <div>
        Purchased Date: {{$header->created_at}}
    </div>
    <div>
        @foreach($cart as $item)
            <div>
                <div>
                    <img src="{{Storage::url($item['cover'])}}" alt="">
                </div>
                <div>
                    <div>
                        {{$item['name']}}
                        {{$item['price']}}
                    </div>
                </div>
            </div>
        @endforeach
        <div>
            Total Price: {{$total_price}}
        </div>
    </div>
    
@endsection