<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->float("weight");
            $table->unsignedBigInteger("shipping_id")->index();
            $table->unsignedBigInteger('super_package_id')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("shipping_id")
                ->references("id")
                ->on("shippings")
                ->onDelete("Cascade")
                ->onUpdate("Cascade");

            $table->foreign("super_package_id")
                ->references("id")
                ->on("super_packages")
                ->onDelete("Cascade")
                ->onUpdate("Cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
