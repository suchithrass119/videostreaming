<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";
    protected $fillable = [
        'title',       // Add title here
        'picpath',   // Include other fields if necessary
        'status',
    ];
}
