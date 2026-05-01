<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
 
    protected $table = 'orders';
 
    protected $fillable = [
        'reference_num',
        'customer_id',
        'sales_rep_id',
        'shipping_address',
        'delivery_type',
        'proof_of_payment',
        'status',
        'total_amount',
    ];
 
    // ── Relationships ─────────────────────────────────────────────────────────
 
    /**
     * An order has many line items (products or quotations).
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
 
    /**
     * The customer who placed this order.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
 
    /**
     * The sales rep assigned to this order.
     */
    public function salesRep()
    {
        return $this->belongsTo(User::class, 'sales_rep_id');
    }
 
    // ── Helpers ───────────────────────────────────────────────────────────────
 
    /**
     * Compute the total amount from all order items.
     * Uses discounted_price if available, otherwise unit_price.
     */
    public function computeTotal(): float
    {
        return $this->items->sum(function ($item) {
            $price = $item->discounted_price ?? $item->unit_price;
            return $price * $item->quantity;
        });
    }
}
