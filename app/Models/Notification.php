<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use GuzzleHttp\Psr7\Request;

class Notification extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}