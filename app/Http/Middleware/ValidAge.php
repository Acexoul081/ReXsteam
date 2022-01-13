<?php

namespace App\Http\Middleware;

use App\Models\Game;
use Closure;
use DateTime;
use Illuminate\Http\Request;

class ValidAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $game = Game::find($request->id);
        if($game->adult === 1){
            $verified = session()->get('age_verified');
            if ($verified == null){
                return response()->view('validate_age', compact('game'));
            }
            if((new DateTime)->diff(new DateTime($verified))->y < 17){
                return response()->redirectToRoute('home');
            }
        }
        
        return $next($request);   
    }
}
