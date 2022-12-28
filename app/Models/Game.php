<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
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
