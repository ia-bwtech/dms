<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class league extends Model
{
    use HasFactory;

    /**
     * Get the sport that owns the league
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(sport::class, 'sport_id', 'id');
    }
}
