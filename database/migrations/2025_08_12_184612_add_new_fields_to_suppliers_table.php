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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('supplier_id')->unique()->after('id');
            $table->string('secondary_phone')->nullable()->after('phone');
            $table->boolean('is_blacklisted')->default(false)->after('status');
            $table->text('notes')->nullable()->after('is_blacklisted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn(['supplier_id', 'secondary_phone', 'is_blacklisted', 'notes']);
        });
    }
};
