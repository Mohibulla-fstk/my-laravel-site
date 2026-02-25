<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comboimages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('combo_id')->constrained('combos')->onDelete('cascade'); // combo এর সাথে relation
            $table->string('image'); // image path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comboimages');
    }
};
