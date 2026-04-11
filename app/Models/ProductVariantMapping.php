<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantMapping extends Model
{
    use HasFactory;

    protected $table = 'product_variant_mappings';

    public function key()
    {
        return $this->belongsTo(ProductVariantKey::class, 'product_variant_key_id');
    }

    public function value()
    {
        return $this->belongsTo(ProductVariantValue::class, 'product_variant_value_id');
    }
}
