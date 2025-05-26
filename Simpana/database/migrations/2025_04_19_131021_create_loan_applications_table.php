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
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('loan_product'); // pendidikan, usaha, konsumtif
            $table->text('application_note')->nullable();
            $table->decimal('loan_amount', 15, 2);
            $table->integer('tenor');
            $table->date('application_date');
            $table->date('first_payment_date');
            $table->enum('payment_method', ['cash', 'transfer', 'debit']);
            $table->text('collateral')->nullable();
            $table->json('documents')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_applications');
    }
};
