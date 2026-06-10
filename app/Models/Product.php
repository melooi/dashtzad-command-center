<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'category',
        'raw_description',
        'specs',
        'purchase_price',
        'sale_price',
        'stock_quantity',
        'status',
        'assigned_to',
        'notes',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function qaChecks(): HasMany
    {
        return $this->hasMany(ProductQaCheck::class);
    }

    public function latestQaCheck(): HasOne
    {
        return $this->hasOne(ProductQaCheck::class)->latestOfMany('checked_at');
    }

    public static function statusLabels(): array
    {
        return [
            'raw' => 'خام (Raw)',
            'incomplete' => 'ناقص (Incomplete)',
            'needs_content' => 'نیازمند محتوا (Needs Content)',
            'needs_price' => 'نیازمند قیمت (Needs Price)',
            'needs_image' => 'نیازمند تصویر (Needs Image)',
            'ready_for_review' => 'آماده بررسی (Ready for Review)',
            'ready_to_publish' => 'آماده انتشار (Ready to Publish)',
            'published' => 'منتشرشده (Published)',
            'rejected' => 'ردشده (Rejected)',
        ];
    }
}
