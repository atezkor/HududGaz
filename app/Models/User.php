<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;


/**
 * @property int id
 * @property-read int $role_id
 * @property-read int $organization_id
 */
class User extends Authenticatable {
    use HasFactory, Notifiable, HasApiTokens;

    /* Roles */
    public const ROLE_ADMIN = 1;
    public const TECHNIC = 2;
    public const ORGAN = 3;
    public const DESIGNER = 4;
    public const ENGINEER = 5;
    public const MOUNTER = 6;
    public const DIRECTOR = 7;
    /* ~ Roles */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'patronymic', // surname -> lastname, patronymic -> second_name
        'role_id', 'username', 'password',
        'organization_id', 'position',
        'avatar', 'locale', 'mac_address'
    ];

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

    public function organ(): BelongsTo {
        return $this->belongsTo(Organ::class, 'organization_id');
    }

    public function getLastToken(): string {
        $token = $this->tokens()->orderByDesc('id')->firstOr(function() {
            return (object)[];
        });

        $token->plainTextToken = Str::random(40);
        //        return (new NewAccessToken($token, $token->getKey() . '|' . $token->plainTextToken))->plainTextToken;
        return "";
    }
}
