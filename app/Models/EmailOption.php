<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailOption extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'bet_placed',
        'bet_won',
        'bet_lost',
        'subscribed_bet_placed'
    ];
    public $timestamps=false;
}
