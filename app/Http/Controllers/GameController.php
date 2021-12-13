<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;

class GameController extends Controller
{
    public function manage(){
        return view('manage_game');
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
            'price' => 'required'
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
        $game->adult = 1;

        $game->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
