<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class order_header extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'order_date',
        'total',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->order_number = self::generateOrderNumber();
        });
    }

    public static function generateOrderNumber()
    {
        return 'ORD-' . date('YmdHis') . '-' . Str::random(6);
    }

    public function user()
    {
        return $this->belongsTo(UserAcc::class);
    }

    public function orderLines()
    {
        return $this->hasMany(order_lines::class);
    }

    public static function getTotalSalesToday()
    {
        return self::whereDate('order_date', today()) // Filter orders created today
                    ->sum('total'); // Sum the total field
    }

    public static function getOrdersCountToday()
    {
        return self::whereDate('order_date', today()) // Filter orders created today
                    ->distinct('user_id') // Count distinct user_ids (customers)
                    ->count('user_id'); // Count the distinct customer orders
    }
}
