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
        Schema::create('post_interactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('postid')->constrained('posts')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); 
                  
            $table->foreignId('userid')->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); 

            $table->string('interactiontype', 50); 
            $table->unique(['postid', 'userid', 'interactiontype']);

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_interactions');
    }
};
