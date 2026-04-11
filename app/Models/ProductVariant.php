<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    public function mappings()
    {
        return $this->hasMany(ProductVariantMapping::class, 'product_variant_id');
    }
}
