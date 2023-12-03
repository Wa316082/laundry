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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->string('total_payable');
            $table->string('invoice_number')->nullable();
            $table->string('ref_no')->nullable();
            $table->enum('transaction_type', ['payment', 'order', 'expense']);
            $table->enum('order_status', ['Order Initialized', 'Order Prepairing', 'Ready to Deliver', 'Delivered'])->nullable();
            $table->enum('payment_type', ['debit', 'credit'])->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->enum('transaction_status', ['paid','due','partial'])->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('business_id')->nullable();
            $table->dateTime('transaction_date');
            $table->dateTime('estimate_delivery_date')->nullable();
            $table->dateTime('deliver_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
