<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigInteger('cid', true)->unsigned();
			$table->string('email',100)->nullable();
			$table->string('first_name',100)->nullable();
			$table->string('last_name',100)->nullable();
			$table->string('position',100)->nullable();
			$table->string('linkedin',100)->nullable();
			$table->string('twitter',100)->nullable();
			$table->string('phone_number',100)->nullable();
            $table->bigInteger('lid')->unsigned()->index('contact_lid_foreign');
			 $table->foreign('lid')->references('id')->on('leads')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		$table->dropForeign('contact_lid_foreign');
        Schema::dropIfExists('contacts');
    }
}
