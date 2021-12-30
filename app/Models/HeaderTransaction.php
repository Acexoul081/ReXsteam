<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderTransaction extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $casts = [
        'id' => 'string'
    ];

    function user(){
        return $this->belongsTo(User::class);
    }

    function details(){
        return $this->hasMany(DetailTransaction::class, 'transaction_id', 'id');
    }

    function games(){
        return $this->belongsToMany(Game::class, 'detail_transactions', 'transaction_id', 'game_id');
    }
}
