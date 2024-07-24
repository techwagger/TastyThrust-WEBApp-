<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public function purchase() {
        return $this->hasMany(Purchase::class, 'vendor_id');
    }
}
