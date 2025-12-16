<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayoutName extends Model
{
    use HasFactory;

    protected $table = 'layout_names';

    protected $fillable = [
        'layout_id',
        'name',
        'border_color',
        'shape',
        'bg_color',
        'color',
        'category_id',
        'subcategory_id',
        'product_id'
    ];

    public function layout()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }
    public function layouts()
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
