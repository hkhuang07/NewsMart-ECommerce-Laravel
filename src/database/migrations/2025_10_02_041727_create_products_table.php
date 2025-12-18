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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('categoryid')->constrained('categories')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreignId('brandid')->constrained('brands')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreignId('salerid')->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            $table->string('name');
            $table->string('slug');
            $table->string('sku',50);
            $table->text('description');
            $table->decimal('price');
            $table->integer('stockquantity')->default(0);
            $table->decimal('discount',5,2)->default(0.00);

            $table->decimal('averragerate',2,1)->default(0.0);
            $table->integer('favorites')->default(0);
            $table->integer('purchases')->default(0);
            $table->integer('views')->default(0);
            $table->boolean('isactive')->default(true);            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
