<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuperPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_packages', function (Blueprint $table) {
            $table->id();
            $table->float('max_weight');
            $table->unsignedBigInteger("cargo_id")->index();
            $table->unsignedBigInteger("user_id")->index();
            $table->timestamps();

            $table->foreign("cargo_id")
                ->references("id")
                ->on("cargos")
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
        Schema::dropIfExists('super_packages');
    }
}
