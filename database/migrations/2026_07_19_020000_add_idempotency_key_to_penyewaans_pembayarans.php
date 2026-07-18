<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('penyewaans', function (Blueprint $table) {
            $table->string('idempotency_key')->nullable()->after('status')->unique()->nullable();
        });

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('idempotency_key')->nullable()->after('payment_method')->unique()->nullable();
        });
    }

    public function down()
    {
        Schema::table('penyewaans', function (Blueprint $table) {
            $table->dropColumn('idempotency_key');
        });

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn('idempotency_key');
        });
    }
};
