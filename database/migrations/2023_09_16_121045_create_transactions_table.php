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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('code');
            $table->string('expediteur');
            $table->string('destinataire');
            $table->integer('phoneNumber');
            $table->integer('montant');
            $table->float('frais');
            $table->float('total');
            $table->string('observation');
            $table->boolean('validation')->default(false);
            $table->enum('mode_paiement', ['Cash', 'Mpesa', 'Orange Money','Airtel Money ']);
            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedBigInteger("destination_id")->index();

            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign("destination_id")
                ->references("id")
                ->on("destinations")
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
        Schema::dropIfExists('transactions');
    }
};
