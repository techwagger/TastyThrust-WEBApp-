<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchase extends Model
{
    use HasFactory;
    protected $table = 'return_purchase';
    protected $primaryKey = 'id';

    public function purchaseDetails() {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

}
