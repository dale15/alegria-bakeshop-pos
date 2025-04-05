<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name', 'price', 'unit_of_measure', 'description'];

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function costings()
    {
        return $this->hasMany(Product_ingredient::class);
    }

    public function getBaseUnit(): float
    {
        return match ($this->unit_of_measure) {
            'grams', 'ml', 'millimeter', 'g' => 1000,
            'pcs', 'pieces' => 1,
            default => 1
        };
    }
}
