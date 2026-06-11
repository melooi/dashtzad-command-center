<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'phone', 'panel_user_id', 'ip_address', 'user_agent', 'status', 'attempts',
    ];

    public static function record(array $data): void
    {
        try {
            static::create($data);
        } catch (\Throwable) {}
    }
}
