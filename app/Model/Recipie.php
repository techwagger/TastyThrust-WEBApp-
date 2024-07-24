<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipie extends Model
{
    use HasFactory;

    protected $table = 'recipie';
    protected $primaryKey = 'id';

    public function recipieIngredients() {
        return $this->hasMany(RecipieIngredient::class, 'recipie_id');
    }
}
