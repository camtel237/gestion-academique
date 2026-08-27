<?php
// database/migrations/0001_01_01_000001_create_sessions_table.php
// Ajoutée : la table sessions existait en base (SESSION_DRIVER=database) mais
// n'avait pas de migration associée, ce qui casse la persistance de connexion
// sur toute installation fraîche (migrate / migrate:fresh) -> déconnexion au reload.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('sessions')) {
            return;
        }

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
