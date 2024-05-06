<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add additional columns
            $table->enum('account_type', ['Individual', 'Business'])->default('Individual');
            $table->decimal('balance', 12, 2)->default(0);
        });
    }


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn('account_type');
            $table->dropColumn('balance');
        });
    }
};
