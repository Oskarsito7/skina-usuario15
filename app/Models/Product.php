<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['subcategory_id', 'name', 'status'];

    // Un producto pertenece a muchas subcategoría.

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'product_subcategory', 'product_id', 'subcategory_id');
    }
}
