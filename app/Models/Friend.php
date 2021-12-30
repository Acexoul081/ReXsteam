<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    public $timestamps = false;
    // protected $primaryKey = ['user_id', 'friend_id'];
    public $incrementing = false;

    function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    function friend(){
        return $this->belongsTo(User::class, 'friend_id', 'id');
    }
}
