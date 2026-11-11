<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('hosting_sinkholes')) {
            Schema::create('hosting_sinkholes', function (Blueprint $table) {
                $table->id();
                $table->string('domain')->unique();
                $table->string('target_ip', 45)->default('0.0.0.0');
                $table->boolean('enabled')->default(true);
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('hosting_audits')) {
            Schema::create('hosting_audits', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('action', 60)->index();
                $table->string('target', 255)->nullable();
                $table->json('payload')->nullable();
                $table->string('result', 20)->default('ok');
                $table->string('ip', 45)->nullable();
                $table->timestamps();

                $table->index('created_at');
            });
        }

        if (! Schema::hasTable('hosting_cron_jobs')) {
            Schema::create('hosting_cron_jobs', function (Blueprint $table) {
                $table->id();
                $table->string('name', 120);
                $table->string('schedule', 30);
                $table->text('command');
                $table->text('description')->nullable();
                $table->timestamp('last_run_at')->nullable();
                $table->string('last_status', 20)->default('never');
                $table->text('last_output')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('hosting_cron_jobs');
        Schema::dropIfExists('hosting_audits');
        Schema::dropIfExists('hosting_sinkholes');
    }
};
