<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Tl extends Authenticatable
{
    use Notifiable;

    protected $guard = 'TL';

    protected $fillable = [
        'name',
       
         'role',    
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}