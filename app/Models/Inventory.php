<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = "inventory";
    protected $primaryKey = 'id';

    protected $fillable = ['ingredients_name', 'stocks'];

    protected $casts = [ 'stocks' => 'decimal:3', // Cast stocks to decimal with 3 decimal places
    ];

    // Define the relationship with Product (many-to-many)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_inventory', 'inventory_id', 'product_id');
    }

}
