<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkMail extends Model
{
    use HasFactory;

    protected $fillable=[
        'text',
        'subject'
    ];

    public function recipients(){
        return $this->hasMany(BulkMailRecipient::class,'mail_id');
    }
}
