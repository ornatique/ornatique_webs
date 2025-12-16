<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    public   $dates = ['created_at', 'updated_at'];
    const ACTIVE = 'status';


    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function products()
    {
        return $this->hasMany(Order::class, 'order_id', 'order_id')->with('product');
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return date("d/m/Y H:i", strtotime($value));
    // }

    // public function getUpdatedAtAttribute($value)
    // {
    //     return   date("d/m/Y H:i", strtotime($value));
    // }
}