<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnPurchaseIngredientItem extends Model
{
    use HasFactory;
    protected $table = 'return_purchase_ingredient_items';
    protected $primaryKey = 'id';
}
