<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OtpCode extends Model
{
    protected $fillable = ['phone', 'code', 'expires_at', 'attempts', 'used', 'ip_address'];

    protected $casts = [
        'expires_at' => 'datetime',
        'used'       => 'boolean',
    ];

    public function isValid(): bool
    {
        return !$this->used
            && $this->expires_at->isFuture()
            && $this->attempts < 3;
    }

    public function incrementAttempts(): void
    {
        $this->increment('attempts');
    }

    public function markUsed(): void
    {
        $this->update(['used' => true]);
    }

    /** Invalidate all previous active OTPs for this phone before issuing a new one. */
    public static function invalidatePhone(string $phone): void
    {
        static::where('phone', $phone)->where('used', false)->update(['used' => true]);
    }
}
