<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller
{
    public function manage(){
        $searchs = Game::simplePaginate(8);
        return view('manage_game', compact('searchs'));
    }

    public function searchManage(Request $request){
        $searchs = DB::table('games');
        if (isset($request->name)){
            $searchs->where(
                'name', 'like', '%'.$request->name.'%',
            );
        }
        if (!empty($request->category)){
            $searchs->orWhereIn('category', $request->category);
        }
        $searchs = $searchs->paginate(8);
        return view('manage_game', ['searchs'=>$searchs]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::all();
        return $games;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create_game');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGameRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $request->validate([
            'name'=> 'required',
            'description' => 'required',
            'long_description' => 'required',
            'category' => 'required',
            'developer' => 'required',
            'publisher' => 'required',
            'price' => 'required',
            'image'=> 'file|mimes:jpg|max:100',
            'trailer'=> 'file|mimes:webm|max:102400'
        ]);

        $img_path = $request->file('image')->store('public/images');
        $vid_path = $request->file('trailer')->store('public/videos');

        $game = new Game();
        $game->name = $request->name;
        $game->description = $request->description;
        $game->long_description = $request->long_description;
        $game->category = $request->category;
        $game->developer = $request->developer;
        $game->publisher = $request->publisher;
        $game->price = $request->price;
        $game->cover = $img_path;
        $game->trailer = $vid_path;
        if(!$request->adult){
            $game->adult = 0;
        }else{
            $game->adult = $request->adult;
        }
        
        $game->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::find($id);
        return view('detail_game', compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        return view('update_game', compact("game"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGameRequest  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        $img_path = $request->file('image')->store('public/images');
        $vid_path = $request->file('trailer')->store('public/videos');

        $game->description = $request->description;
        $game->long_description = $request->long_description;
        $game->category = $request->category;
        $game->price = $request->price;
        //hapus file cover dan trailer sebelumnya
        $game->cover = $img_path;
        $game->trailer = $vid_path;

        $game->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //confirmation dialog
        $game->delete();
        return back();
    }
}
