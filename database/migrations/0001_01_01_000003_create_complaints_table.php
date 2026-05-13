<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name', 100);
            $table->string('email', 150);
            $table->string('phone', 30)->nullable();
            $table->string('anonymous', 2)->default('NO');
            $table->string('category', 100);
            $table->json('areas')->nullable();
            $table->string('other_area', 150)->nullable();
            $table->string('public_servant_name', 150)->nullable();
            $table->string('public_servant_position', 150)->nullable();
            $table->text('public_servant_physical_description')->nullable();
            $table->unsignedTinyInteger('incident_day')->nullable();
            $table->string('incident_month', 30)->nullable();
            $table->unsignedSmallInteger('incident_year')->nullable();
            $table->time('incident_time')->nullable();
            $table->string('incident_location', 200)->nullable();
            $table->text('message');
            $table->string('witnesses', 2)->default('NO');
            $table->string('has_evidence', 2)->default('NO');
            $table->string('status', 50)->default('Nueva');
            $table->json('attachments')->nullable();
            $table->text('response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
