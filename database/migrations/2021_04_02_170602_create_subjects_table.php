<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('batch_id')->unsigned()->nullable();
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->bigInteger('internal1')->default(0);
            $table->bigInteger('internal2')->default(0);
            $table->bigInteger('finalquiz')->default(0);
            $table->bigInteger('finalpractical')->default(0);
            $table->bigInteger('assignment')->default(0);
            $table->bigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
