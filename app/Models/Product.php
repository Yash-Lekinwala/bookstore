<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public static function checkQty($product_long_id, $qty)
    {
        $quantity = self::whereLongId($product_long_id)->first()->quantity;
        return $qty <= $quantity;
    }
}
