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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); 

            // Khóa ngoại
            $table->foreignId('orderid')->constrained('orders')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); 
                  
            $table->foreignId('productid')->constrained('products')
                  ->onUpdate('cascade')
                  ->onDelete('restrict'); 

            $table->integer('quantity'); 
            $table->decimal('priceatorder', 18, 2);
            $table->decimal('discountatorder', 5, 2)->default(0.00); 
            $table->decimal('subtotal', 18, 2); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
