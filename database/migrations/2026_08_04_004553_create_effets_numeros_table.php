<?php
// database/migrations/2026_07_03_000000_create_effets_numeros_table.php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up(): void
    {
        Schema::create('effets_numeros', function (Blueprint $table) {
            $table->id();
            $table->string('type', 30); // 'certificat', 'releve', 'carte'...
            $table->unsignedSmallInteger('annee');
            $table->unsignedInteger('numero'); // compteur séquentiel pour ce type + cette année
            $table->foreignId('inscription_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
 
            $table->unique(['type', 'annee', 'numero']);
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('effets_numeros');
    }
};