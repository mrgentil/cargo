<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpeditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expeditions', function (Blueprint $table)
{
    $table->id();
    $table->timestamps();

    $table->date('start_date');
    $table->date("end_date");
    $table->float('frette');
    $table->float('douane');
    $table->float('totalKilo');
    $table->float('nombreTotalColis');
    $table->integer('nombreTotal');
    $table->boolean('is_closed')->default(false);

    $table->unsignedBigInteger("expedition_type_id")->index();

    $table->foreign("expedition_type_id")
        ->references("id")
        ->on("expedition_types")
        ->cascadeOnDelete()
        ->cascadeOnUpdate();
    $table->timestamps();
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
    Schema::dropIfExists('expeditions');
}
}
