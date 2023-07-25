<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('code');
            $table->date("date");
            $table->string('expediteur');
            $table->string('destinataire');
            $table->float('kilo');
            $table->integer('montant');
            $table->integer('montantPaye');
            $table->integer('montantAPayer');
            $table->enum('mode_paiement', ['Carte Bancaire', 'Cash', 'E-Money']);
            $table->enum('type_colis', ['Gros', 'Petit']);

            $table->unsignedBigInteger("agence_id")->index();
            $table->unsignedBigInteger("groupage_id")->index();
            $table->unsignedBigInteger("category_id")->index();

            $table->foreign("agence_id")
                ->references("id")
                ->on("agences")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign("groupage_id")
                ->references("id")
                ->on("groupages")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign("category_id")
                ->references("id")
                ->on("categories")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public
    function down()
    {
        Schema::dropIfExists('colis');
    }
}
