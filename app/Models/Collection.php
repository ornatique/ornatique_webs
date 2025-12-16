<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;


    protected $fillable = [
        'category_id',
        'subcategory_id',
        'product_id',
        // 'bg_color',
        'color',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subcategory()
    {
        return $this->hasOne(Subcategory::class, 'id', 'subcategory_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
