<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'agent_name'
    ];

    public function referralcount()
    {
        return User::where('referral_code', $this->name)->count();
    }
}
