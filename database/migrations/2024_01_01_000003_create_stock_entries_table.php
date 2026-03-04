<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('stock_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->integer('quantity');
            $table->string('delivery_reference')->unique();
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('stock_entries');
    }
};
