<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $table = "product_sizes";
    protected $primaryKey = 'id';

    protected $fillable = ['product_id', 'size', 'price', 'size_index'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
