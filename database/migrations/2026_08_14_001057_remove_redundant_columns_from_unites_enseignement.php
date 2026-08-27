<?php
// database/migrations/2026_08_14_001057_remove_redundant_columns_from_unites_enseignement.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. Colonnes redondantes (sûr à relancer, ne fait rien si déjà supprimées)
        if (Schema::hasColumn('unites_enseignement', 'niveau_id')) {
            Schema::table('unites_enseignement', function (Blueprint $table) {
                $table->dropConstrainedForeignId('niveau_id');
            });
        }

        if (Schema::hasColumn('unites_enseignement', 'annee_academique_id')) {
            Schema::table('unites_enseignement', function (Blueprint $table) {
                $table->dropConstrainedForeignId('annee_academique_id');
            });
        }

        // 2. Supprime l'ancienne contrainte semestre_id (ON DELETE SET NULL, incompatible avec NOT NULL)
        $constraintExists = DB::select("
            SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'unites_enseignement'
              AND CONSTRAINT_NAME = 'unites_enseignement_semestre_id_foreign'
        ");

        if (!empty($constraintExists)) {
            Schema::table('unites_enseignement', function (Blueprint $table) {
                $table->dropForeign(['semestre_id']);
            });
        }

        // 3. Rend la colonne obligatoire
        Schema::table('unites_enseignement', function (Blueprint $table) {
            $table->foreignId('semestre_id')->nullable(false)->change();
        });

        // 4. Recrée la contrainte avec restrictOnDelete (empêche de supprimer un semestre
        //    tant qu'il contient des UE, au lieu de mettre semestre_id à NULL)
        Schema::table('unites_enseignement', function (Blueprint $table) {
            $table->foreign('semestre_id')
                ->references('id')->on('semestres')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('unites_enseignement', function (Blueprint $table) {
            $table->dropForeign(['semestre_id']);
            $table->foreignId('semestre_id')->nullable()->change();
            $table->foreign('semestre_id')->references('id')->on('semestres')->nullOnDelete();
            $table->foreignId('niveau_id')->nullable()->constrained('niveaux')->nullOnDelete();
            $table->foreignId('annee_academique_id')->nullable()->constrained('annees_academiques')->nullOnDelete();
        });
    }
};