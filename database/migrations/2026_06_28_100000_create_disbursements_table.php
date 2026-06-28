<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Un décaissement (disbursement) = l'argent qui part de votre
     * compte marchand Labyrinthe vers le portefeuille mobile money
     * du client, après approbation du dossier de crédit.
     */
    public function up(): void
    {
        Schema::create('disbursements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('loan_application_id')
                ->constrained('loan_applications')
                ->onDelete('cascade');

            $table->foreignId('agent_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->decimal('amount', 15, 2);
            $table->string('mobile_number');

            $table->enum('status', [
                'pending', 'processing', 'confirmed', 'failed',
            ])->default('pending');

            $table->timestamp('disbursed_at')->nullable();

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disbursements');
    }
};
