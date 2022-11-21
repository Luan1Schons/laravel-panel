<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabbosFavorites extends Model
{
    use HasFactory;
    protected $table = 'habbos_favorites';
    protected $fillable = ['user_id', 'habbo_id'];
}
