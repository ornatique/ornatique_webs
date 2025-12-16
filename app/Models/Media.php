<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;


    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subcategory()
    {
        return $this->hasOne(Subcategory::class, 'id', 'subcategory_id');
    }

    public function likes()
    {
        return $this->hasMany(Media_like::class, 'media_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Media_comment::class, 'media_id', 'id');
    }
}