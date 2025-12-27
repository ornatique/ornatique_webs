<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppSetting extends Model
{
   use HasFactory;

    protected $table = 'app_settings'; // optional if table name is plural

    protected $fillable = [
        'platform',
        'min_supported_version',
        'force_update',
        'message',
        'latest_version',
        'store_url'
    ];
}
