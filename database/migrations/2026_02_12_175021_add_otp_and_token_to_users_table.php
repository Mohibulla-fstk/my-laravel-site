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
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'otp')) {
            $table->string('otp')->nullable()->after('password');
        }
        if (!Schema::hasColumn('users', 'otp_expires_at')) {
            $table->timestamp('otp_expires_at')->nullable()->after('otp');
        }
        if (!Schema::hasColumn('users', 'password_reset_token')) {
            $table->string('password_reset_token')->nullable()->after('otp_expires_at');
        }
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['otp', 'otp_expires_at', 'password_reset_token']);
    });
}

};
