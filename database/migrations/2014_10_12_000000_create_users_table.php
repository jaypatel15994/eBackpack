<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('batch_id')->unsigned()->nullable()->comment("0 = teachers");
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->bigInteger('created_by')->default(0)->comment("0 = teacher register");
            $table->integer('user_type')->default(0)->comment("0= teachers, 1= students");
            $table->integer('status')->default(0)->comment("0= inactive, 1= active");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
