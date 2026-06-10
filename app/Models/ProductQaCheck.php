<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductQaCheck extends Model
{
    protected $fillable = [
        'product_id',
        'readiness_score',
        'missing_items',
        'checked_at',
    ];

    protected $casts = [
        'checked_at' => 'datetime',
        'readiness_score' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getMissingItemsArrayAttribute(): array
    {
        if (empty($this->missing_items)) {
            return [];
        }

        $decoded = json_decode($this->missing_items, true);

        return is_array($decoded) ? $decoded : [];
    }
}
