<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;
     protected $fillable = [
    'name',
    'category_id',
    'subcategory_id',
    'number',
    'size',
    'hole_size',
    'gross_weight',
    'less_weight',
    'weight',
    'quantity',
    'gallery',
    'label_product',
    'color',
    'charge',
    'bg_color',
    'order_confirm',
];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subcategory()
    {
        return $this->hasOne(Subcategory::class, 'id', 'subcategory_id');
    }
    // public function wishlist()
    // {
    //     return  $this->hasOne(Wishlist::class, 'product_id', 'id')->where('user_id', $_REQUEST['user_id']);
    // }

    public function wishlist()
    {
        return $this->hasOne(Wishlist::class, 'product_id', 'id')->where('user_id', ['id']);
    }
    //  public function getWeightAttribute($value)
    // {
    //     return round($value, 3);
    // }
}