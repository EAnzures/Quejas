<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            if (! Schema::hasColumn('complaints', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }

            if (! Schema::hasColumn('complaints', 'attachments')) {
                $table->json('attachments')->nullable()->after('status');
            }

            if (! Schema::hasColumn('complaints', 'response')) {
                $table->text('response')->nullable()->after('attachments');
            }

            if (! Schema::hasColumn('complaints', 'responded_at')) {
                $table->timestamp('responded_at')->nullable()->after('response');
            }

            if (! Schema::hasColumn('complaints', 'responded_by')) {
                $table->foreignId('responded_by')->nullable()->after('responded_at')->constrained('users')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            if (Schema::hasColumn('complaints', 'responded_by')) {
                $table->dropConstrainedForeignId('responded_by');
            }

            foreach (['responded_at', 'response', 'attachments'] as $column) {
                if (Schema::hasColumn('complaints', $column)) {
                    $table->dropColumn($column);
                }
            }

            if (Schema::hasColumn('complaints', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};
