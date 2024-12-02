<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $primaryKey = 'id';

    protected $fillable = ['product_name', 'product_category', 'product_status', 'medio', 'grande', 'image_name'];

    // Define the relationship with Inventory (many-to-many)
    public function inventory()
    {
        return $this->belongsToMany(Inventory::class, 'product_inventory', 'product_id', 'inventory_id');
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

}
