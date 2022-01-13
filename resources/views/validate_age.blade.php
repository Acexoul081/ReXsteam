@extends('layouts.app')
@section('content')
<div class="container">
    <form method="POST" action="{{route('validate_age')}}">
        @csrf
        <img class="card-img" src="{{Storage::url($game->cover)}}" alt="thumbnail">
        <input type="date" name="datebirth" id="">
        <button class="btn btn-primary">Validate</button>
    </form>
</div>
@endsection