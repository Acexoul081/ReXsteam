@extends('layouts.app')

@php
    $total_price = 0;
    foreach($cart as $item){
        $total_price+=$item['price'];
    }
@endphp
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
    <form method="POST" action="{{ route('store_transaction') }}">
        @csrf
        <div class="form-group">
            <label for="name">Card Name</label>
            <input placeholder="Card Name" type="text" class="form-control @error('card_name') is-invalid @enderror" name="card_name" id="name" value="{{ old('card_name') }}">
        </div>
        <div class="form-group">
            <label for="number">Card Number</label>
            <input type="text" placeholder="0000 0000 0000 0000" class="form-control @error('card_number') is-invalid @enderror" name="card_number" id="number" value="{{ old('card_number') }}">
        </div>
        <div class="form-group">
            <label>Expired Date</label>
            <input type="text" placeholder="MM" class="form-control  @error('month') is-invalid @enderror" value="{{ old('month') }}" name="month">
            <input type="text" placeholder="YYYY" class="form-control @error('year') is-invalid @enderror" name="year" value="{{ old('year') }}">
            <label for="cvc">CVC / CVV</label>
            <input type="text" placeholder="3 or 4 digit number" class="form-control @error('cvc') is-invalid @enderror" name="cvc" id="cvc" value="{{ old('cvc') }}">
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <select class="form-control" id="country" name="country">
                <option value="Indonesia">Indonesia</option>
                <option value="USA">USA</option>
                <option value="UK">UK</option>
                <option value="Australia">Australia</option>
                <option value="Africa">Africa</option>
                <option value="German">German</option>
            </select>
        </div>
        <div class="form-group">
            <label for="zip">ZIP</label>
            <input type="text" placeholder="ZIP" class="form-control @error('zip') is-invalid @enderror" name="zip" id="zip" value="{{ old('zip') }}">
        </div>
        Total Price: {{$total_price}}

        <button class="btn btn-primary" type="submit">Checkout</button>
    </form>
    <form action="{{ route('cancel_transaction') }}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" type="submit">Cancel</button>
    </form>
</div>
@endsection