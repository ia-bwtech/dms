<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['image_remove'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopePlays($query)
    {
        return $query->wins + $query->losses;
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bets()
    {
        return $this->hasMany(Bet::class, 'user_id', 'id');
    }

    /**
     * Get all of the packages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packages()
    {
        return $this->hasMany(Package::class, 'user_id', 'id');
    }

    public function emailoption()
    {
        return $this->hasOne(EmailOption::class, 'user_id', 'id');
    }

    /**
     * Get all of the subscriptions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id', 'id');
    }
    public function subscribedPicks1($id = null)
    {
        if ($id == null) {

            $subscribedPicks = Bet::join('users', 'bets.user_id', 'users.id')
                ->join('packages', 'users.id', 'packages.user_id')
                ->join('subscriptions', 'packages.id', 'subscriptions.package_id')
                ->select('bets.*', 'users.name as package_owner')
                ->where('bets.is_verified', 1)
                ->where('bets.status', 1)
                ->where('subscriptions.user_id', auth()->id())
                ->where('subscriptions.status', 1)
                ->orderBy('bets.id','desc')
                ->get();
        } else {
            $subscribedPicks = DB::table('bets')
                ->join('users', 'bets.user_id', 'users.id')
                ->join('packages', 'users.id', 'packages.user_id')
                ->join('subscriptions', 'packages.id', 'subscriptions.package_id')
                ->select('bets.*', 'users.name as package_owner')
                ->where('bets.user_id', $id)
                ->where('bets.status', 1)
                ->where('bets.is_verified', 1)
                ->where('subscriptions.user_id', auth()->id())
                ->where('subscriptions.status', 1)
                ->get();
        }
        return $subscribedPicks;
    }
}
