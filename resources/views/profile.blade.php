@extends('layouts.app')

@section('content')
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        @foreach ($errors->all() as $error)
            <div>{{$error}}</div>
        @endforeach
    </div>
@endif
<div class="container d-flex">
    
    @include('layouts.sidebar')
    <div>
        <div>{{$user->username}} Profile</div>
        <form enctype="multipart/form-data" action="{{route('user_update', ['user'=>Auth::user()->id])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="d-flex">
                <div>
                    <div class="d-flex">
                        <div class="form-group">
                            <label for="username">User Name</label>
                            <input type="text" class="form-control" name="username" id="username" value="{{$user->username}}">
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <input type="number" class="form-control" name="level" id="level" value="{{$user->level}}">
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" class="form-control" name="fullname" id="fullname" value="{{$user->fullname}}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="image">
                        <img src="{{Storage::url($user->image)}}" alt="">
                    </label>
                    <input class="d-none" type="file" name="image" id="image">
                </div>
            </div>
            
            <div class="form-group">
                <label for="curr_pass">Current Password</label>
                <input type="password" class="form-control" name="curr_pass" id="curr_pass">
            </div>
            <div class="form-group">
                <label for="new_pass">New Password</label>
                <input type="password" class="form-control" name="new_pass" id="new_pass">
            </div><div class="form-group">
                <label for="new_pass_confirmation">Confirm New Password</label>
                <input type="password" class="form-control" name="new_pass_confirmation" id="new_pass_confirmation">
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>
@endsection