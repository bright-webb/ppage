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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('developer_id');
            $table->string('file_path');
            $table->string('thumbnail')->nullable();
            $table->json('schema')->nullable();
            $table->enum('status', ['pending', 'active', 'rejected'])->default('pending'); // Status of the template
            $table->text('description')->nullable(); 
            $table->boolean('is_free')->default(false); 
            $table->decimal('price', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
