<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductQaCheck;
use Illuminate\Support\Carbon;

class ProductQaService
{
    private const REQUIRED_FIELDS = [
        'name' => 'Name',
        'sku' => 'SKU',
        'category' => 'Category',
        'sale_price' => 'Sale Price',
        'stock_quantity' => 'Stock Quantity',
        'raw_description' => 'Description',
        'specs' => 'Specs',
    ];

    public function run(Product $product): ProductQaCheck
    {
        $missing = [];

        foreach (self::REQUIRED_FIELDS as $field => $label) {
            $value = $product->getAttribute($field);
            if ($value === null || $value === '' || $value === 0) {
                $missing[] = $label;
            }
        }

        $total = count(self::REQUIRED_FIELDS);
        $passed = $total - count($missing);
        $score = (int) round(($passed / $total) * 100);

        return ProductQaCheck::create([
            'product_id' => $product->id,
            'readiness_score' => $score,
            'missing_items' => json_encode($missing),
            'checked_at' => Carbon::now(),
        ]);
    }
}
