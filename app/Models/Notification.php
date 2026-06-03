<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'employee_id',
        'requested_by',
        'message',
        'status',
        'read_at'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function hrAdmin()
    {
        return $this->belongsTo(HrAdmin::class, 'requested_by');
    }
}