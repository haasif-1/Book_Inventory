<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // identification
            $table->string('sku')->nullable()->unique();
            $table->string('title');

            // pricing & cost
            $table->decimal('cost_price', 10, 2)->default(0);
            $table->decimal('sell_price', 10, 2)->default(0);

            // inventory
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(1);        // low-stock threshold
            $table->integer('reorder_point')->nullable();

            // meta
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // path
            $table->string('location')->nullable(); // shelf/aisle

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}

