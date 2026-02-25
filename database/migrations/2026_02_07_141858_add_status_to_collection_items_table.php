<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('collection_items', function (Blueprint $table) {
        $table->tinyInteger('status')->default(1)->after('id'); // 1 = active, 0 = inactive
    });
}

public function down()
{
    Schema::table('collection_items', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

};
