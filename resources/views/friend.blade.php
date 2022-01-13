@extends('layouts.app')

@section('content')
<div class="container d-flex">
    @include('layouts.sidebar')
    <div>
        <div>
            Friends
        </div>
        <div>
            <form action="{{route('add_friend', ['user'=>Auth::user()->id])}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Add Friend</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="name" id="name">
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <div>Incoming Friend Request</div>
            <div>
                @foreach($incomings as $incoming)
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{$incoming->user->username}}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{$incoming->user->role}}</h6>
                            <img src="{{Storage::url($incoming->user->image)}}" class="rounded-circle" alt="user_image">
                            <p class="card-text">{{$incoming->user->level}}</p>
                            <form action="{{route('response_friend', ['user'=>Auth::user()->id])}}" method="POST">
                                @csrf
                                @method('PUT')
                                <button  name="accept" value="{{$incoming->user->id}}" class="btn btn-primary">Accept</button>
                                <button name="reject" value="{{$incoming->user->id}}" class="btn btn-danger">Reject</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div>
            <div>Pending Friend Request</div>
            <div>
                @foreach($pendings as $pending)
                    <div class="card" style="width: 18rem;">
                        <div class="card-body mw-100">
                            <h5 class="card-title">{{$pending->friend->username}}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{$pending->friend->role}}</h6>  
                            <img src="{{Storage::url($pending->friend->image)}}" class="rounded-circle" alt="user_image">
                            <p class="card-text">{{$pending->friend->level}}</p>
                            <form action="{{route('cancel_friend', ['user'=>Auth::user()->id])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" name="id" value="{{$pending->friend->id}}">Cancel</button>
                            </form>
                            
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div>
            <div>Your Friends</div>
            <div>
                @foreach($friends as $friend)
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{$friend->username}}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{$friend->role}}</h6>
                            <img src="{{Storage::url($friend->image)}}" class="rounded-circle" alt="user_image">
                            <p class="card-text">{{$friend->level}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection