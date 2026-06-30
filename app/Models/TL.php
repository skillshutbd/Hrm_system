<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Tl extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $table = 'team_leads';
    protected $guard = 'Tl';

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

    // এই TL এর নিজের employee record
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // এই TL যে যে department handle করে
    public function departments()
    {
        return $this->hasMany(Department::class, 'hod_id', 'employee_id');
    }
}