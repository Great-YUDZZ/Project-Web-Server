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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('issuer');
            $table->string('credential_id')->nullable();
            $table->string('issued_date')->nullable();
            $table->string('duration_hours')->nullable();
            $table->string('verification_status')->nullable()->default('BSrE BSSN Valid');
            $table->text('description')->nullable();
            $table->string('credential_url')->nullable();
            $table->string('file_path')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
