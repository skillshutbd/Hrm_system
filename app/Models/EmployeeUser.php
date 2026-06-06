<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class EmployeeUser extends Authenticatable
{
    use Notifiable,HasRoles;

    protected $table = 'employeeUser';
    protected $guard = 'employee';

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'employee_id', 'department_id',
       
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}