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
        Schema::create('discount_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Senior Citizen", "Bulk Purchase", "Loyalty"
            $table->string('code')->unique(); // e.g., "SENIOR", "BULK10"
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed_amount'])->default('percentage');
            $table->decimal('value', 10, 2); // Percentage or fixed amount
            $table->decimal('minimum_amount', 10, 2)->default(0); // Minimum order amount
            $table->decimal('maximum_discount', 10, 2)->nullable(); // Maximum discount amount
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_automatic')->default(false); // Auto-apply or manual
            $table->json('applicable_products')->nullable(); // Specific products
            $table->json('applicable_categories')->nullable(); // Specific categories
            $table->integer('usage_limit')->nullable(); // Per customer
            $table->text('terms_conditions')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['is_active', 'valid_from', 'valid_until']);
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_types');
    }
};