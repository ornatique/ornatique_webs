<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Custum_order extends Model
{
    use HasFactory;

    const ACTIVE = 'status';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
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