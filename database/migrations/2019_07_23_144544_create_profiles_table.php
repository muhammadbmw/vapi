<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('street',200)->nullable();
			$table->string('city',20)->nullable();
			$table->string('province',20)->nullable();
			$table->string('postal_code',20)->nullable();
			$table->string('phone',20)->nullable();
			$table->string('image',200)->nullable();
            $table->timestamps();
			$table->bigInteger('user_id')->unsigned()->index('profiles_user_id_foreign');
			 $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
