<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class leave extends Model
{
    protected $table = 'leaves';

protected $fillable = [
    'employee_id', 'leave_type_id', 'from_date', 'to_date',
    'duration', 'reason', 'attachment', 'is_showcase',
    'tl_status', 'tl_note', 'status', 'hr_note',
];

public function leaveType() {
    return $this->belongsTo(LeaveType::class);
}

public function employee() {
    return $this->belongsTo(Employee::class);
}





public function notifications()
{
    return $this->hasMany(LeaveNotification::class);
}
}
