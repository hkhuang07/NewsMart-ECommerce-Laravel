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
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('orderid')->unique()->constrained('orders')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); 
            
            $table->string('paymentmethod', 50); 
            $table->decimal('amount', 18, 2); 
            $table->string('currency', 10)->default('$'); 
            $table->string('Status', 50)->default('Pending'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_transactions');
    }
};
