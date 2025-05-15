<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            $table->enum('payment_type', ['installment', 'full_payment'])->default('installment');
            $table->decimal('remaining_amount', 15, 2)->nullable();
            $table->integer('remaining_installments')->nullable();
        });
    }

    public function down()
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            $table->dropColumn(['payment_type', 'remaining_amount', 'remaining_installments']);
        });
    }
}; 