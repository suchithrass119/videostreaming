<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    protected $table = "videos";
    protected $fillable = [
        'title',       // Add title here
        'description',   // Include other fields if necessary
        'url',
        'main_url',
        'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class); // Assuming 'category_id' is the foreign key
    }
}
