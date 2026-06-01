<?php
namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Employee extends Model
{
    use HasFactory;

   protected $fillable = [
    'employee_id',
    'nid',
    'name',
    'email',
    'phone',
    'employee_id',
    'nid',
    'profile_picture',
    'date_of_birth',
    'gender',
    'address',
    'emergency_contact_name',
    'emergency_contact_phone',
    'emergency_contact_relationship',
    'department_id',
    'designation',
    'role',
    'hire_date',
    'status',
    'password',
];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

