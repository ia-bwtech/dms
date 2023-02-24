<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    /**
     * Get all of the odds for the Game
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function odds()
    {
        return $this->hasMany(Odd::class, 'game_id', 'game_id');
    }
}
