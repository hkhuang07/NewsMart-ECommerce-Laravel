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
        Schema::create('shipping_information', function (Blueprint $table) {
            $table->id();

            $table->foreignId('orderid')->unique()->constrained('orders')
                  ->onUpdate('cascade')
                  ->onDelete('cascade'); 
            
            $table->string('address'); 
            $table->string('city', 100)->nullable(); 
            $table->string('state', 100)->nullable(); 
            $table->string('postalcode', 20)->nullable(); 
            $table->string('recipientname'); 
            $table->string('recipientphone', 20); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_information');
    }
};
