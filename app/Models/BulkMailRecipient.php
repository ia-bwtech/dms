<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkMailRecipient extends Model
{
    use HasFactory;
    protected $table="bulk_mail_recipients";
    public $timestamps=false;
    protected $fillable=[
        'mail_id',
        'user_id'
    ];
}
