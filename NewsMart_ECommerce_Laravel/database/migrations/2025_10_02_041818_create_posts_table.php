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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại
            $table->foreignId('authorid')->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreignId('productid')->nullable()->constrained('products')
                  ->onUpdate('cascade')
                  ->onDelete('set null'); 
            $table->foreignId('posttypeid')->constrained('post_types')
                  ->onUpdate('cascade')
                  ->onDelete('restrict'); 
            $table->foreignId('topicid')->nullable()->constrained('topics')
                  ->onUpdate('cascade')
                  ->onDelete('set null'); 

            $table->string('title'); 
            $table->string('slug')->unique(); 
            $table->longText('content'); 
            $table->string('status', 50)->default('Pending'); 
            $table->string('image')->nullable();
            $table->integer('views')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
