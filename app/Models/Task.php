<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'created_by',
        'assigned_to',
        'priority',
        'status',
        'due_at',
        'category',
        'related_type',
        'related_id',
        'requires_approval',
        'approved_by',
        'completed_at',
    ];

    protected $casts = [
        'due_at' => 'datetime',
        'completed_at' => 'datetime',
        'requires_approval' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }

    public static function priorityLabels(): array
    {
        return [
            'low' => 'کم (Low)',
            'normal' => 'عادی (Normal)',
            'high' => 'بالا (High)',
            'urgent' => 'فوری (Urgent)',
        ];
    }

    public static function statusLabels(): array
    {
        return [
            'backlog' => 'در صف (Backlog)',
            'today' => 'امروز (Today)',
            'in_progress' => 'در حال انجام (In Progress)',
            'blocked' => 'مسدود (Blocked)',
            'needs_review' => 'نیازمند بررسی (Needs Review)',
            'done' => 'انجام‌شده (Done)',
            'cancelled' => 'لغوشده (Cancelled)',
        ];
    }
}
