<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabboBoosts extends Model
{
    use HasFactory;

    protected $table = 'habbo_boosts';
    protected $fillable = ['user_id', 'habbo_id'];

}
