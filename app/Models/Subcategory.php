<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subcategory extends Model
{

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id', 'id');
    }
}