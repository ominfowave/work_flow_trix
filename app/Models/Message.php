<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public $guarded = [];

    
    public function messageFile()
    {
        return $this->hasMany(messageFile::class, 'message_id', 'id');
    }
}
