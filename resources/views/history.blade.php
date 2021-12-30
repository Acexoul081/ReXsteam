@extends('layouts.app')

@php
    $total_price = 0;
@endphp
@section('content')
<div class="container d-flex">
    @include('layouts.sidebar')
    <div>
        <div>Transaction History</div>
        <div>
            @foreach($transactions as $transaction)
            <div class="card">
                <div class="card-header">
                    <div>Transaction ID: {{$transaction->id}}</div>
                    <div>Purchase Date: {{$transaction->created_at}}</div>
                </div>
                <div class="card-body d-flex">
                    @foreach($transaction->games as $game)
                        <div class="w-50 m-2">
                            @php
                                $total_price+=$game->price;
                            @endphp
                            <img class="card-img" src="{{Storage::url($game->cover)}}" alt="">
                        </div>    
                    @endforeach
                </div>
                <div class="card-footer text-muted">
                    Total Price: {{$total_price}}
                </div>
            </div>
            @endforeach
        </div>
    </div>
        
</div>
@endsection