<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['to','from','text', 'uuid_session', 'type'];

    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
}
