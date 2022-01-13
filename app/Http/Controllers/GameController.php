<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\HeaderTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\MessageBag;

use function PHPUnit\Framework\isEmpty;

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

    public function search(Request $request){
        if ($request::get('search')) {
            $searchs = DB::table('games');
            $searchs->where(
                'name', 'like', '%'.$request::get('search').'%',
            );
            $games = $searchs->get();
        }else{
            $games = Game::all();
        }
        if($games->isEmpty()){
            $errors = new MessageBag();
            $errors->add('no_games', 'There are no games content can be showed right now!');
            return view('home', compact('errors'));
        }
        return view('home', compact('games'));
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
            'name'=> 'required|string|unique:games',
            'description' => 'required|string|max:500',
            'long_description' => 'required|string|max:2000',
            'category' => 'required',
            'developer' => 'required',
            'publisher' => 'required',
            'price' => 'required|numeric|max:1000000',
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
        if($this->user_own($game)){
            return view('detail_game', compact('game'))->with(["user_own"=>true]);
        }
        return view('detail_game', compact('game'));
    }

    private function user_own(Game $game){
        $header = HeaderTransaction::where('user_id', Auth::user()->id)->first();
        foreach($header->details as $detail){
            if($detail->game_id === $game->id){
                return True;
            }
        }
        return false;
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
        $request->validate([
            'description' => 'required|string|max:500',
            'long_description' => 'required|string|max:2000',
            'category' => 'required',
            'price' => 'required|numeric|max:1000000',
            'image'=> 'file|mimes:jpg|max:100',
            'trailer'=> 'file|mimes:webm|max:102400'
        ]);
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
