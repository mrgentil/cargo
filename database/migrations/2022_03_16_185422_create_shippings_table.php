<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sender_id")->index();
            $table->unsignedBigInteger("recipient_id")->index();

            $table->float("amount");
            $table->float('tarif');

            $table->float("payed_sender_amount");
            $table->float("payed_recipient_amount");

            $table->string("secret_code");
            $table->string("code");

            $table->boolean("is_shipped")->default(false);
            $table->string("confirmed_secret_code")->nullable();
            $table->string("id_card")->nullable();

            $table->unsignedBigInteger("user_id")->index();
            $table->unsignedBigInteger("sending_town_id")->index();
            $table->unsignedBigInteger("destination_town_id")->index();
            $table->unsignedBigInteger("cargo_id")->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("sender_id")->references("id")->on("customers")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("recipient_id")->references("id")->on("customers")->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign("sending_town_id")->references("id")->on("towns")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("destination_town_id")->references("id")->on("towns")->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign("cargo_id")
                ->references("id")
                ->on("cargos")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shippings');
    }
}
