<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Habbos;
use App\Models\Update;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function habbos()
    {
        return $this->hasOne(Habbos::class,'user_id', 'id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    /**
    * Update model relationship
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function updates()
    {
        return $this->hasMany(Update::class);
    }

    public function ChatsBans()
    {
        return $this->hasOne(ChatBans::class, ['user_id', 'id']);
    }
}
