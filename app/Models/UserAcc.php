<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Change this
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAcc extends Authenticatable // Change this
{
    use HasFactory;

    protected $table = 'user_accs';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
