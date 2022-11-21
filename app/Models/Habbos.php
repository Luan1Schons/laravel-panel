<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habbos extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'mysql_database',
        'mysql_name',
        'mysql_password',
        'domain',
        'emu_port',
        'emu_mus_port',
        'instance_status',
        'arcturus_status',
        'mysql_status',
        'nitro_status',
        'avatar',
        'description',
        'bg_card',
        'bg_font_color',
        'likes',
        'users_online',
        'players',
        'staff_vacancy',
        'image',
        'events_time',
        'inauguration_date',
        'status',
    ];


    public function boosts(){
        return $this->hasMany(HabboBoosts::class, 'user_id', 'id');
    }
}
