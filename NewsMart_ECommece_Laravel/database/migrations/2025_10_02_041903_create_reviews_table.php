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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('userid')->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('restrict'); 
                  
            $table->foreignId('productid')->constrained('products')
                  ->onUpdate('cascade')
                  ->onDelete('restrict'); 

            $table->foreignId('orderid')->nullable()->constrained('orders')
                  ->onUpdate('cascade')
                  ->onDelete('set null'); 

            $table->integer('rating'); 
            
            $table->text('content')->nullable();
            $table->string('status', 50)->default('Pending'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
