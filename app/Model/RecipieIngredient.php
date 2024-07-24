<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipieIngredient extends Model
{
    use HasFactory;
    protected $table = 'recipie_ingredient';
    protected $primaryKey = 'id';
}
