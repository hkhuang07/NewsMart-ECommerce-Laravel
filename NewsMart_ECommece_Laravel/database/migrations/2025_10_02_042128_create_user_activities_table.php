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
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('userid')->nullable()->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null'); 
            
            $table->string('actiontype', 50); 
            $table->text('details')->nullable(); 
            $table->string('ipaddress', 50)->nullable(); 
            $table->text('useragent')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};
