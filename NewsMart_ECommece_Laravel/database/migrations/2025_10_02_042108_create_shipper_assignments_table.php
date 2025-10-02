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
        Schema::create('shipper_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orderid')->unique()->constrained('orders')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('shipperid')->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('restrict'); 

            $table->dateTime('assignedat')->useCurrent(); 
            $table->dateTime('pickedupat')->nullable(); 
            $table->dateTime('deliveredat')->nullable(); 
            $table->dateTime('failedat')->nullable(); 
            $table->text('notes')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipper_assignments');
    }
};
