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
        Schema::create('comptabilite_cargos', function (Blueprint $table) {
            $table->id();
            $table->integer('  nombre_total_colis');
            $table->integer('  tonnageTotal');
            $table->float('  montantTotal');
            $table->float('  frette');
            $table->float('  douane');
            $table->integer('  colisInitial');
            $table->float('  kiloInitial');
            $table->float('  montantInitial');
            $table->integer('  colisSorti');
            $table->float('  kiloSorti');
            $table->float('  montantSorti');
            $table->integer('  colisRestant');
            $table->float('  montantRestant');
            $table->integer('  totalRestant');
            $table->unsignedBigInteger("agence_id")->index();
            $table->unsignedBigInteger("pays_ville_id")->index();
            $table->unsignedBigInteger("depense_id")->index();

            $table->foreign("agence_id")
                ->references("id")
                ->on("agences")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign("pays_ville_id")
                ->references("id")
                ->on("pays_villes")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign("depense_id")
                ->references("id")
                ->on("depenses")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptabilite_cargos');
    }
};
