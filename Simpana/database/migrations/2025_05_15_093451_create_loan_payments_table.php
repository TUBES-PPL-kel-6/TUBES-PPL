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
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_application_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->integer('installment_number');
            $table->date('payment_date')->nullable(); // Make this nullable
            $table->date('due_date');
            $table->string('payment_method')->nullable(); // Make this nullable
            $table->string('payment_proof')->nullable();
            $table->enum('status', ['pending', 'paid', 'overdue', 'verified', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_payments');
    }
};
