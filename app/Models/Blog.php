<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable=[
        'title','blog','meta_title','meta_description','banner','banner_description','user_id','published','category_id','short_text','meta_title','meta_description'
    ];
    public function category()
    {
        return $this->belongsTo(BlogCategory::class,'category_id');
    }
}
