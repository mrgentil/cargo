<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('code')->unique();
            $table->date('start_date');
            $table->date("end_date");
            $table->float('tarif');
            $table->boolean('is_closed')->default(false);

            $table->unsignedBigInteger("cargo_type_id")->index();

            $table->unsignedBigInteger("user_id")->index();

            $table->foreign("cargo_type_id")
                ->references("id")
                ->on("cargo_types")
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign("user_id")
                ->references("id")
                ->on("users")
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
        Schema::dropIfExists('cargos');
    }
}
