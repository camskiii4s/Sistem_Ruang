<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_lists', function (Blueprint $table) {
            $table->string('konsumsi')->nullable()->after('purpose');
        });
    }

    public function down(): void
    {
        Schema::table('booking_lists', function (Blueprint $table) {
            $table->dropColumn('konsumsi');
        });
    }
};
