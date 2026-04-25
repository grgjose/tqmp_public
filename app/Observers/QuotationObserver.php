<?php

namespace App\Observers;

use App\Models\Quotation;
use App\Models\Cart;
use Carbon\Carbon;

class QuotationObserver
{
    /**
     * Called every time a Quotation is retrieved from the DB.
     * If valid_until has passed and status is not already Expired/Cancelled,
     * we update it and disable matching cart rows.
     */
    public function retrieved(Quotation $quotation): void
    {
        if (
            $quotation->valid_until !== null &&
            Carbon::now()->greaterThan($quotation->valid_until) &&
            !in_array($quotation->status, ['Expired', 'Cancelled'])
        ) {
            // Silently update — avoid triggering the observer recursively
            Quotation::withoutEvents(function () use ($quotation) {
                $quotation->status = 'Expired';
                $quotation->save();
            });

            // Remove expired quotation from any open carts
            Cart::where('quotation_id', $quotation->id)->delete();
        }
    }
}
