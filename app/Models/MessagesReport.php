<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessagesReport extends Model
{
    use HasFactory;
    protected $table = 'messages_report';
    protected $fillable = ['user_id', 'message_id', 'motive', 'user_reported_id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function userReported()
    {
        return $this->hasOne(User::class, 'id', 'user_reported_id');
    }

    public function message()
    {
        return $this->hasOne(Message::class, 'id', 'message_id');
    }

}
