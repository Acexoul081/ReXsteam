@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage Game</h2>
    <div>
        <form action="{{route('manage_search')}}" method="post">
            @csrf
            <label for="games_name">Filter by Games Name</label>
            <input type="text" class="form-control" name="name" id="games_name">
            <label for="games_category">Filter by Games Category</label>
            <div>
                <div>
                    <input type="checkbox" name="category[]" value="Action" id="action">
                    <label for="action">Action</label>
                </div>
                <div>
                    <input type="checkbox" name="category[]" value="Role Playing" id="role-playing">
                    <label for="role-playing">Role-Playing</label>
                </div>
                <div>
                    <input type="checkbox" name="category[]" value="Strategy" id="strategy">
                    <label for="strategy">Strategy</label>
                </div>
                <div>
                    <input type="checkbox" name="category[]" value="Adventure & Casual" id="adventure_casual">
                    <label for="adventure_casual">Adventure & Casual</label>
                </div>
                <div>
                    <input type="checkbox" name="category[]" value="Simulation" id="simulation">
                    <label for="simulation">Simulation</label>
                </div>
                <div>
                    <input type="checkbox" name="category[]" value="sport_racing" id="Sport & Racing">
                    <label for="sport_racing">Sport & Racing</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
        @forelse ($searchs as $game)
            <div>
                <a href="{{ route('detail_game', ['id'=>$game->id]); }}" class="card px-0 m-2" style="width: 30rem;">
                    <img class="card-img" src="{{Storage::url($game->cover)}}" alt="thumbnail">
                    <div class="card-img-overlay text-white d-flex flex-column justify-content-end align-items-start">
                        <h4 class="card-title">{{$game->name}}</h4>
                        <h6 class="card-subtitle mb-2">{{$game->category}}</h6>
                    </div>
                </a>
                <form method="post" action= "{{ route('delete_game', ['game'=>$game->id]); }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn">Delete</button>
                </form>
                <form method="post" action= "{{ route('edit_game', ['game'=>$game->id]); }}">
                    @csrf
                    <input type="hidden" name="game" value="{{$game->id}}">
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>
        @empty
            <div>
                There are no game content to shown right now
            </div>
        @endforelse
    

    @if (Route::has('add_game'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('add_game') }}">{{ __('Create Game') }}</a>
        </li>
    @endif
    <div class="paginator">
        {{ $searchs->links() }}
    </div>

</div>
@endsection