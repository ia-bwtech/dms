<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','name','price','description','duration','from_date','to_date','status','is_admin'
    ];
}
