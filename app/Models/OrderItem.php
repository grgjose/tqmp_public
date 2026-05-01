<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;
 
    protected $table = 'order_items';
 
    protected $fillable = [
        'order_id',
        'product_id',
        'quotation_id',
        'quantity',
        'unit_price',
        'discounted_price',
        'status',
        'remarks',
    ];
 
    // ── Relationships ─────────────────────────────────────────────────────────
 
    /**
     * The parent order this item belongs to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
 
    /**
     * The product linked to this item (nullable).
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
 
    /**
     * The quotation linked to this item (nullable).
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
 
    // ── Helpers ───────────────────────────────────────────────────────────────
 
    /**
     * Returns the effective price (discounted if available, otherwise unit price).
     */
    public function effectivePrice(): float
    {
        return $this->discounted_price ?? $this->unit_price;
    }
 
    /**
     * Returns the line total (effective price × quantity).
     */
    public function lineTotal(): float
    {
        return $this->effectivePrice() * $this->quantity;
    }
}
