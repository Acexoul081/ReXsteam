<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index(){
        $cart = $this->getCart();
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
            $totalcart = "0";
            echo json_encode(array('totalcart' => $totalcart)); die;
            return;
        }
    }

    public function insert(Request $request){
        $id = $request->game;
        if(Cookie::get('cart'))
        {
            $cookie_data = stripslashes(Cookie::get('cart'));
            $cart = json_decode($cookie_data, true);
        }
        else
        {
            $cart = array();
        }
        $game = Game::find($id);
        if($game){
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
        }
        //validasi cart udah keisi belum buat
        //https://www.fundaofwebit.com/post/how-to-make-shopping-cart-using-cookie-in-laravel-with-ajax-request
        return back();
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
        return;
    }
}
