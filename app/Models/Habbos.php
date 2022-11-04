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
        'instance_status'
    ];
}
