<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App_version extends Model
{
    use HasFactory;

    protected $table = 'app_versions'; // optional if table name is plural

    protected $fillable = [
        'platform',
        'version',
        'force_update',
        'message',
        'store_url'
    ];
}
