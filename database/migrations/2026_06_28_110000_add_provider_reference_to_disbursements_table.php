<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disbursements', function (Blueprint $table) {
            $table->string('provider_reference')->nullable()->after('mobile_number');
            $table->string('provider')->nullable()->after('provider_reference');
        });
    }

    public function down(): void
    {
        Schema::table('disbursements', function (Blueprint $table) {
            $table->dropColumn(['provider_reference', 'provider']);
        });
    }
};
