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
        Schema::create('comptabilite_transferts', function (Blueprint $table) {
            $table->id();
            $table->float('montant');
            $table->integer('nombreTransaction');
            $table->integer('montantTotal');
            $table->integer('totalRestant');
            $table->integer('montantOut');
            $table->string('motifOut');
            $table->enum('mode_paiement', ['Cash', 'Mpesa', 'Orange Money','Airtel Money ']);

            $table->unsignedBigInteger("agence_id")->index();
            $table->unsignedBigInteger("pays_ville_id")->index();
            $table->unsignedBigInteger("commission_id")->index();

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

            $table->foreign("commission_id")
                ->references("id")
                ->on("commissions")
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
        Schema::dropIfExists('comptabilite_transferts');
    }
};
