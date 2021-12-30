@extends('layouts.app')

@php
    $total_price = 0;
    foreach($cart as $item){
        $total_price+=$item['price'];
    }
@endphp
@section('content')
<div class="container">
    <form method="POST" action="{{ route('store_transaction') }}">
        @csrf
        <div class="form-group">
            <label for="name">Card Name</label>
            <input type="text" class="form-control" name="card_name" id="name">
        </div>
        <div class="form-group">
            <label for="number">Card Number</label>
            <input type="text" class="form-control" name="card_number" id="number">
        </div>
        <div class="form-group">
            <label>Expired Date</label>
            <input type="text" class="form-control" name="month">
            <input type="text" class="form-control" name="year">

            <label for="cvc">CVC / CVV</label>
            <input type="text" class="form-control" name="cvc" id="cvc">
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
            <input type="text" class="form-control" name="zip" id="zip">
        </div>
        Total Price: {{$total_price}}
        <button class="btn btn-primary" type="submit">Checkout</button>
    </form>
</div>
@endsection