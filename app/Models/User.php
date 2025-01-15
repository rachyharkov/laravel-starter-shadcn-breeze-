<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
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
        'email_verified_at' => 'datetime:d/m/Y H:i:s',
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s',
        'birth_date' => 'datetime:Y-m-d',
        'password' => 'hashed',
    ];


    /**
     * Interact with the user's avatar.
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value != null ? asset('storage/uploads/images/avatars/' . $value) : "https://www.gravatar.com/avatar/" . md5(strtolower(trim(auth()->user()->email))). "&s=500",
        );
    }

    /**
     * Get the user roles for the user.
     */
    public function user_roles()
    {
        return $this->hasMany(UserRole::class);
    }
}
