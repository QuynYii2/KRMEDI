<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertNotification extends Model
{
    use HasFactory;

    protected $fillable = ['link','message','from_user_id','to_user_id'];

    public function fromContact()
    {
        return $this->hasOne(User::class, 'id', 'from_user_id');
    }
}
