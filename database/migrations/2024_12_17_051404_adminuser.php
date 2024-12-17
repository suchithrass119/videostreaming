<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('adminusers', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('username'); // Video title
            $table->text('name')->nullable(); // Optional description
            $table->string('password'); // Trailer Video URL
            $table->integer('user_status'); // Main Video  URL
            $table->string('mob_number'); // Trailer Video URL
            $table->string('picpath'); // Trailer Video URL
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adminusers'); // Rollback
    }
};
