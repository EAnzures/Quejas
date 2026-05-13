<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            if (! Schema::hasColumn('complaints', 'phone')) {
                $table->string('phone', 30)->nullable()->after('email');
            }

            if (! Schema::hasColumn('complaints', 'anonymous')) {
                $table->string('anonymous', 2)->default('NO')->after('phone');
            }

            if (! Schema::hasColumn('complaints', 'areas')) {
                $table->json('areas')->nullable()->after('category');
            }

            if (! Schema::hasColumn('complaints', 'other_area')) {
                $table->string('other_area', 150)->nullable()->after('areas');
            }

            if (! Schema::hasColumn('complaints', 'public_servant_name')) {
                $table->string('public_servant_name', 150)->nullable()->after('other_area');
            }

            if (! Schema::hasColumn('complaints', 'public_servant_position')) {
                $table->string('public_servant_position', 150)->nullable()->after('public_servant_name');
            }

            if (! Schema::hasColumn('complaints', 'public_servant_physical_description')) {
                $table->text('public_servant_physical_description')->nullable()->after('public_servant_position');
            }

            if (! Schema::hasColumn('complaints', 'incident_day')) {
                $table->unsignedTinyInteger('incident_day')->nullable()->after('public_servant_physical_description');
            }

            if (! Schema::hasColumn('complaints', 'incident_month')) {
                $table->string('incident_month', 30)->nullable()->after('incident_day');
            }

            if (! Schema::hasColumn('complaints', 'incident_year')) {
                $table->unsignedSmallInteger('incident_year')->nullable()->after('incident_month');
            }

            if (! Schema::hasColumn('complaints', 'incident_time')) {
                $table->time('incident_time')->nullable()->after('incident_year');
            }

            if (! Schema::hasColumn('complaints', 'incident_location')) {
                $table->string('incident_location', 200)->nullable()->after('incident_time');
            }

            if (! Schema::hasColumn('complaints', 'witnesses')) {
                $table->string('witnesses', 2)->default('NO')->after('message');
            }

            if (! Schema::hasColumn('complaints', 'has_evidence')) {
                $table->string('has_evidence', 2)->default('NO')->after('witnesses');
            }
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            foreach ([
                'has_evidence',
                'witnesses',
                'incident_location',
                'incident_time',
                'incident_year',
                'incident_month',
                'incident_day',
                'public_servant_physical_description',
                'public_servant_position',
                'public_servant_name',
                'other_area',
                'areas',
                'anonymous',
                'phone',
            ] as $column) {
                if (Schema::hasColumn('complaints', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
