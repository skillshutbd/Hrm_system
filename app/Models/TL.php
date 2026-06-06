<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Tl extends Authenticatable
{
      use Notifiable, HasRoles;

    protected $table = 'team_leads';  // এটা add করো
    protected $guard = 'Tl';          // 'team_leads' → 'Tl'

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function department()
    {
        return $this -> hasOneThrough(Department::class,Employee::class,id,id,employee_id,departmetn_id);
    }
}