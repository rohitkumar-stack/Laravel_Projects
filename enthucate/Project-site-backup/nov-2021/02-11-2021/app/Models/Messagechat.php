<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messagechat extends Model
{
    protected $table = "message_chat";

     public function fromUser()
    {
        return $this->belongsTo('App\Models\User', 'from_user');
    }

    public function toUser()
    {
        return $this->belongsTo('App\Models\User', 'to_user');
    }
}
