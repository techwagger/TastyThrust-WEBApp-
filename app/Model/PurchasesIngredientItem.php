<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasesIngredientItem extends Model
{
    use HasFactory;

    protected $table = 'purchases_ingredient_items';
    protected $primaryKey = 'id';
}
