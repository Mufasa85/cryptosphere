<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_application_id')->constrained('loan_applications')->cascadeOnDelete();
            $table->unsignedInteger('installment_number');
            $table->date('due_date');
            $table->decimal('principal_amount', 12, 2);
            $table->decimal('interest_amount', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('paid_amount', 12, 2)->default(0.00);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_schedules');
    }
};
