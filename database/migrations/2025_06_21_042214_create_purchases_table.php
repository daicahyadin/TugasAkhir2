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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->foreignId('promo_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('payment_method', ['cash', 'credit']);
            $table->string('ktp_photo');
            $table->string('npwp_photo')->nullable();
            $table->enum('team', ['WARRIOR','RAIDON','KSYOW','ANDUONOHU','KONSEL','UNAHA']);
            $table->enum('status', ['pending','approved','completed','cancelled'])->default('pending');
            $table->string('whatsapp_number');
            $table->decimal('original_price', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('total_price', 15, 2);
            $table->decimal('down_payment', 15, 2)->nullable();
            $table->integer('loan_term')->nullable();
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('ticket_code')->unique();
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
