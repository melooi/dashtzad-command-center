<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanelUser extends Model
{
    protected $fillable = [
        'phone', 'name', 'telegram_id', 'email', 'avatar',
        'department', 'position', 'access_reason', 'referrer',
        'role', 'status',
        'approved_by', 'approved_at', 'rejected_at', 'rejection_reason',
        'last_login_at',
    ];

    protected $casts = [
        'approved_at'   => 'datetime',
        'rejected_at'   => 'datetime',
        'last_login_at' => 'datetime',
    ];

    const ROLES = [
        'super_admin'        => 'مدیر کل',
        'project_manager'    => 'مدیر پروژه',
        'product_specialist' => 'کارشناس محصول',
        'content_specialist' => 'کارشناس محتوا',
        'seo_specialist'     => 'کارشناس سئو',
        'sales_specialist'   => 'کارشناس فروش',
        'viewer'             => 'مشاهده‌گر',
    ];

    const STATUSES = [
        'pending_profile'  => 'در انتظار تکمیل اطلاعات',
        'pending_approval' => 'در انتظار تأیید',
        'approved'         => 'تأیید شده',
        'rejected'         => 'رد شده',
        'blocked'          => 'مسدود',
        'inactive'         => 'غیرفعال',
    ];

    public function roleName(): string
    {
        return self::ROLES[$this->role] ?? $this->role;
    }

    public function statusName(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'project_manager']);
    }

    public function initial(): string
    {
        $parts = explode(' ', trim($this->name ?? ''));
        $i = mb_substr($parts[0] ?? '?', 0, 1);
        $j = isset($parts[1]) ? mb_substr($parts[1], 0, 1) : '';
        return $i . ($j ? '‌' . $j : '');
    }
}
