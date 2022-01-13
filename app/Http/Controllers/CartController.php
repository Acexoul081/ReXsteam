<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\HeaderTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use phpDocumentor\Reflection\PseudoTypes\True_;

class CartController extends Controller
{
    public function index(){
        $cart = $this->getCart();
        if($cart == null){
            $errors = new MessageBag();
            $errors->add('cart_empty', 'Your Cart is Empty!');
            return view('cart',compact('errors'));
        }
        return view('cart',compact('cart'));  
    }

    public function getCart(){
        if(Cookie::get('cart'))
        {
            $cookie_data = stripslashes(Cookie::get('cart'));
            $cart = json_decode($cookie_data, true);

            return $cart;
        }
        else
        {
            return null;
        }
    }

    public function insert(Request $request){
        $id = $request->game;
        if(Cookie::get('cart'))
        {
            //urus ini 
            $cookie_data = stripslashes(Cookie::get('cart'));
            $cart = json_decode($cookie_data, true);
        }
        else
        {
            $cart = array();
        }
        $game = Game::find($id);

        if($game && !$this->game_in_cart($game, $cart)){
            $item = array(
                'id' => $game->id,
                'cover' => $game->cover,
                'name' => $game->name,
                'price' => $game->price,
                'category' => $game->category
            );
            $cart[] = $item;

            $encode_cart = json_encode($cart);
            $minutes = 120;
            Cookie::queue(Cookie::make('cart', $encode_cart, $minutes));  
        }else{
            return back()->withErrors(["exist_cart"=>"This game already in your cart"]);
        }

        return back();
    }

    private function game_in_cart(Game $game, $cart){
        foreach($cart as $item){
            if($item["id"] === $game->id){
                return true;
            }
        }
        return false;
    }

    public function delete(Request $request){
        $game_id = $request->id;
        $cookie_data = stripslashes(Cookie::get('cart'));
        $cart = json_decode($cookie_data, true);
        $item_id_list = array_column($cart, 'id');
        $prod_id_is_there = $game_id;

        if(in_array($prod_id_is_there, $item_id_list))
        {
            foreach($cart as $keys => $values)
            {
                if($cart[$keys]["id"] == $game_id)
                {
                    unset($cart[$keys]);
                    $item_data = json_encode($cart);
                    $minutes = 60;
                    Cookie::queue(Cookie::make('cart', $item_data, $minutes));
                    return back();
                }
            }
        }
    }

    public function clear(){
        Cookie::queue(Cookie::forget('cart'));
        return redirect('/');
    }
}
