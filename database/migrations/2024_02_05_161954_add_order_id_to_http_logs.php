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
        Schema::table('http_logs', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Order::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('http_logs', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
};
