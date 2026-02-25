<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // যদি coupon_id column না থাকে, add করো
            if (!Schema::hasColumn('orders', 'coupon_id')) {
                $table->foreignId('coupon_id')
                    ->nullable()
                    ->constrained('coupons')
                    ->nullOnDelete();
            }

            // যদি discount_amount column না থাকে, add করো
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 12, 2)
                    ->default(0)
                    ->after('coupon_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign key only if exists
            if (Schema::hasColumn('orders', 'coupon_id')) {
                $table->dropForeign(['coupon_id']);
                $table->dropColumn('coupon_id');
            }

            if (Schema::hasColumn('orders', 'discount_amount')) {
                $table->dropColumn('discount_amount');
            }
        });
    }
};
