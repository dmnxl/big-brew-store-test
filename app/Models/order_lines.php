<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_lines extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_header_id',
        'product_id',
        'quantity',
        'total',
        'inventory_ids'
    ];

    protected $casts = [
        'inventory_ids' => 'array',
    ];

    // Define the relationship to OrderHeader
    public function orderHeader()
    {
        return $this->belongsTo(order_header::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public static function getTotalOrdersToday()
    {
        return self::whereDate('created_at', today()) // Filter orders created today
                    ->sum('quantity'); // Sum the quantity field
    }
}
