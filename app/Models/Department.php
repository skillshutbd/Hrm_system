<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'hod_id'];

        public function teamLead()
        {
            return $this->belongsTo(Tl::class, 'hod_id', 'employee_id');
        }    
}

