<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one',
        'user_two',
        'last_message',
        'last_message_at'
    ];

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one', 'user_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two', 'user_id');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'conversation_id');
    }
}