<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    use HasFactory;
    protected $table = 'layouts';

    // Mass assignable fields
    protected $fillable = [

        'name',
        'color',
        'border',
        'shape',
        'category_id',
        'subcategory_id',
        'product_id',
        'image',
        'status',
    ];

    // Casts for automatic type conversion
    protected $casts = [
        'status' => 'boolean', // '1' or '0' will be treated as boolean
    ];

    // Timestamps are enabled by default (created_at, updated_at)
    public $timestamps = true;


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
    public function layoutName()
    {
        return $this->belongsTo(LayoutName::class, 'layout_name_id');
    }
}
