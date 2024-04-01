<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'title',
        'seen',
        'sender_id',
        'follower',
        'target_url',
        'description',
        'booking_id',
        'cart_id',
        'created_at',
    ];

    public function senders()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function bookings()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function carts()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

    public function followers()
    {
        return $this->belongsTo(User::class, 'follower', 'id');
    }
}