@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" enctype="multipart/form-data" action="{{ route('update_game', ['game'=>$game->id]); }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="description">Game Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"> {{$game->description}} </textarea>
        </div>
        <div class="form-group">
            <label for="long_description">Game Long Description</label>
            <textarea class="form-control" id="long_description" name="long_description" rows="5">{{$game->long_description}}</textarea>
        </div>
        <div class="form-group">
            <label for="category">Game Category</label>
            <select class="form-control" id="category" name="category">
                @if($game->category === "Action")
                    <option value="Action" selected>Action</option>
                @else
                    <option value="Action">Action</option>
                @endif

                @if($game->category === "Role-Playing")
                    <option value="Role-Playing" selected>Role-Playing</option>
                @else
                    <option value="Role-Playing">Role-Playing</option>
                @endif

                @if($game->category === "Strategy")
                    <option value="Strategy" selected>Strategy</option>
                @else
                    <option value="Strategy">Strategy</option>
                @endif

                @if($game->category === "Adventure & Casual")
                    <option value="Adventure & Casual" selected>Adventure & Casual</option>
                @else
                    <option value="Adventure & Casual">Adventure & Casual</option>
                @endif

                @if($game->category === "Simulation")
                    <option value="Simulation" selected>Simulation</option>
                @else
                    <option value="Simulation">Simulation</option>
                @endif

                @if($game->category === "Sport & Racing")
                    <option value="Sport & Racing" selected>Sport & Racing</option>
                @else
                    <option value="Sport & Racing">Sport & Racing</option>
                @endif
            </select>
        </div>
        <div class="form-group">
            <label for="price">Game Price</label>
            <input type="number" class="form-control" name="price" id="price" value="{{$game->price}}">
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="image" name="image" required>
            <label class="custom-file-label" for="image">Choose file... image</label>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="trailer" name="trailer" required>
            <label class="custom-file-label" for="trailer">Choose file... trailer</label>
        </div>
        <button class="btn">Cancel</button>
        <button class="btn btn-primary" type="submit">Update Game</button>
    </form>
    @if($errors->any())
        @foreach ($errors->all() as $error)
            {{$error}}
        @endforeach
    @endif
</div>
@endsection