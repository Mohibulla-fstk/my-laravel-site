<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('combos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            // Category id must match categories.id type (INT UNSIGNED)
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->integer('min_products')->default(1);
            $table->integer('max_products')->default(2);
            $table->decimal('price', 10, 2);
            $table->decimal('new_price', 10, 2)->default(0);
            $table->decimal('old_price', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->integer('stock')->default(0);
            $table->string('stockstatus', 50)->default('in stock');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('combos');
    }
};


