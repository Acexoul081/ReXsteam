@extends('layouts.app')

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
            Total Price: 
        </div>
    </div>
    
@endsection