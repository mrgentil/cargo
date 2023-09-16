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
        Schema::create('etat_caisse_global_transferts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('montantEnvoye');
            $table->integer('montantTotal');
            $table->integer('totalRestant');
            $table->enum('mode_paiement', ['Cash', 'Mpesa', 'Orange Money','Airtel Money ']);
            $table->unsignedBigInteger("agence_id")->index();
            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedBigInteger("commission_id")->index();
            $table->unsignedBigInteger("depense_id")->index();

            $table->foreign("agence_id")
                ->references("id")
                ->on("agences")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign("commission_id")
                ->references("id")
                ->on("commissions")
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
        Schema::dropIfExists('etat_caisse_global_transferts');
    }
};
