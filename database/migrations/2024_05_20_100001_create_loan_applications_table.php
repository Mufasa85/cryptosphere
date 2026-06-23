<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reference')->unique();
            $table->decimal('amount_requested', 12, 2);
            $table->decimal('amount_approved', 12, 2)->nullable();
            $table->text('purpose')->nullable();
            $table->unsignedInteger('duration_months')->default(12);
            $table->decimal('interest_rate', 5, 2)->default(0.00);
            $table->string('status')->default('submitted');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('disbursed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('agent_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_applications');
    }
};
