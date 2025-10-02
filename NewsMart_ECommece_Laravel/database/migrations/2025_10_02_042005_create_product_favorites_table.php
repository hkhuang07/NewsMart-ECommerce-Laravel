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
        Schema::create('product_favorites', function (Blueprint $table) {
            //$table->id();

            $table->foreignId('userid')->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); 
                  
            $table->foreignId('productid')->constrained('products')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); 

            $table->primary(['userid', 'productid']); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_favorites');
    }
};
