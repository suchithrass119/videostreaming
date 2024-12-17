<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = "adminusers";
    protected $fillable = [
        'username',       // Add title here
        'name',   // Include other fields if necessary
        'password',
        'user_status',
        'mob_number',
        'picpath'
    ];
}
