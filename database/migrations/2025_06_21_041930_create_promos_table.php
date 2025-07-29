<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('promos', function (Blueprint $table) {
        $table->id();
        $table->string('type')->default('promo'); // promo, event, news
        $table->string('title');
        $table->string('image')->nullable();
        $table->text('description');
        $table->decimal('discount_percentage', 5, 2)->nullable();
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->boolean('is_active')->default(true);
        $table->text('terms_conditions')->nullable();
        $table->decimal('minimum_purchase', 15, 2)->nullable();
        $table->decimal('maximum_discount', 15, 2)->nullable();
        $table->unsignedBigInteger('created_by')->nullable();
        $table->unsignedBigInteger('updated_by')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
