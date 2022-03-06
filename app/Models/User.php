<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * @property int role
 * @property-read int id
 */
class User extends Authenticatable {
    use HasFactory, Notifiable;

    /* Role */
    public const ADMIN = 1;
    public const TECHNIC = 2;
    public const REGION = 3;
    public const DESIGNER = 4;
    public const ENGINEER = 5;
    public const MOUNTER = 6;
    public const DIRECTOR = 7;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'role', 'organ', 'username', 'lastname', 'patronymic', 'password', 'locale',
        'position', 'avatar', 'mac_address'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
