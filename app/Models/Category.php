<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];

    // Una categoría tiene muchas subcategorías.
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    // Una categoría tiene muchos productos a través de las subcategorías.
    public function products()
    {
        return $this->hasManyThrough(Product::class, Subcategory::class);
    }
}
