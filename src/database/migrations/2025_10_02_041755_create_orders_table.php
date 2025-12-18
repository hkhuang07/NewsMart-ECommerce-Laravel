<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('userid')->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('salerid')->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            
            $table->dateTime('orderdate')->default(DB::raw('CURRENT_TIMESTAMP'));
            
            $table->foreignId('orderstatusid')->constrained('order_statuses')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            
            $table->decimal('totalamount',18,2);
        
            $table->string('paymentmethod',50)->nullable();
            $table->string('paymentstatus',50)->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
