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
        Schema::create('etat_caisse_users', function (Blueprint $table) {
            $table->id();
            $table->integer('nombreColiLivre');
            $table->float('kilototal');
            $table->integer('montantTotal');
            $table->integer('totalRestant');
            $table->string('client');
            $table->string('phoneNumber');
            $table->string('libelle');
            $table->float('kilo');
            $table->float('montant');
            $table->enum('mode_paiement', ['Cash', 'Mpesa', 'Orange Money','Airtel Money ']);
            $table->unsignedBigInteger("expedition_id")->index();
            $table->unsignedBigInteger("depense_id")->index();

            $table->foreign("depense_id")
                ->references("id")
                ->on("depenses")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign("expedition_id")
                ->references("id")
                ->on("expeditions")
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
        Schema::dropIfExists('etat_caisse_users');
    }
};
