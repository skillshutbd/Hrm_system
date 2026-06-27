<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveNotification extends Model
{
    protected $table = 'leave_notifications';

    protected $fillable = [
        'leave_id',
        'recipient_type',
        'recipient_id',
        'type',
        'message',
        'read_at',
    ];

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }

    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }
}