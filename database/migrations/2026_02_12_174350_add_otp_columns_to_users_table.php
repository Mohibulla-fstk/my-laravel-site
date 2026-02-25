<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::table('users', function (Blueprint $table) {
    if (!Schema::hasColumn('users', 'otp')) {
        $table->string('otp')->nullable()->after('password');
    }
    if (!Schema::hasColumn('users', 'otp_created_at')) {
        $table->timestamp('otp_created_at')->nullable()->after('otp');
    }
    if (!Schema::hasColumn('users', 'otp_expires_at')) {
        $table->timestamp('otp_expires_at')->nullable()->after('otp_created_at');
    }
});

    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp', 'otp_created_at', 'otp_expires_at']);
        });
    }
};
