<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class HrAdmin extends Authenticatable
{
    use Notifiable;

    

    protected $guard = 'Hr';

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