<?php
// database/migrations/2026_08_10_000000_add_semestre_id_to_unites_enseignement_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('unites_enseignement', 'semestre_id')) {
            Schema::table('unites_enseignement', function (Blueprint $table) {
                $table->foreignId('semestre_id')->nullable()->after('niveau_id')->constrained('semestres')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('unites_enseignement', function (Blueprint $table) {
            $table->dropConstrainedForeignId('semestre_id');
        });
    }
};