<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media_like extends Model
{
    use HasFactory;

    public function media()
    {
        return $this->hasOne(Media::class, 'id', 'media_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
