<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function vendorDetails() {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function returnPurchaseDetails() {
        return $this->hasMany(ReturnPurchase::class, 'purchase_id');
    }

    public function purchaseIngredientList() {
        return $this->hasMany(PurchasesIngredientItem::class, 'purchase_id');
    }
}
