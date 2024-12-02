<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInvertory extends Model
{
    use HasFactory;

    protected $table = "product_inventory";
    protected $primaryKey = 'id';

    protected $fillable = ['product_id', 'inventory_id', 'size_index', 'quantity', 'unit', 'category'];
}
