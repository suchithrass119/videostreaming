<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('title'); // Video title
            $table->text('description')->nullable(); // Optional description
            $table->string('url'); // Trailer Video URL
            $table->integer('category_id'); // Trailer Video URL
            $table->string('main_url'); // Main Video  URL
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('videos'); // Rollback
    }
    
};
