<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    function detail(){
        return $this->belongsTo(DetailTransaction::class, 'game_id', 'id');
    }
}
