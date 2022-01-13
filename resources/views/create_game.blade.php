@extends('layouts.app')

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
    <form method="POST" enctype="multipart/form-data" action="{{ url()->current() }}">
        @csrf
        <div class="form-group">
            <label for="name">Game Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="description">Game Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="long_description">Game Long Description</label>
            <textarea class="form-control @error('long_description') is-invalid @enderror" id="long_description" name="long_description" rows="5">{{ old('long_description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="category">Game Category</label>
            <select class="form-control" id="category" name="category">
                <option value="Action">Action</option>
                <option value="Role-Playing">Role-Playing</option>
                <option value="Strategy">Strategy</option>
                <option value="Adventure & Casual">Adventure & Casual</option>
                <option value="Simulation">Simulation</option>
                <option value="Sport & Racing">Sport & Racing</option>
            </select>
        </div>
        <div class="form-group">
            <label for="developer">Game Developer</label>
            <input type="text" class="form-control @error('developer') is-invalid @enderror" name="developer" id="developer" value="{{ old('developer') }}">
        </div>
        <div class="form-group">
            <label for="publisher">Game Publisher</label>
            <input type="text" class="form-control @error('publisher') is-invalid @enderror" name="publisher" id="publisher" value="{{ old('publisher') }}">
        </div>
        <div class="form-group">
            <label for="price">Game Price</label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" value="{{ old('price') }}">
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="image" name="image" required>
            <label class="custom-file-label" for="image">Choose file... image</label>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="trailer" name="trailer" required>
            <label class="custom-file-label" for="trailer">Choose file... trailer</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="adult" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Only for adult?
            </label>
        </div>
        <button class="btn btn-primary" name="create" type="submit">Create Game</button>
    </form>
</div>
@endsection