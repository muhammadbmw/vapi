<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
			 $table->bigInteger('id', true)->unsigned();
			 $table->bigInteger('lead_id');
			 $table->string('lead_name')->nullable();
			 $table->string('last_visit',100)->nullable();
			 $table->string('page_views',10)->nullable();
			 $table->string('time_spent',20)->nullable();
			 $table->string('source',100)->nullable();
			 $table->string('industry',100)->nullable();
			 $table->string('country',100)->nullable();
			 $table->string('state',100)->nullable();
			 $table->string('city',100)->nullable();
			 $table->text('headquarter_address')->nullable();
			 $table->longText('visited_pages')->nullable();
			 $table->string('website')->nullable();
			 $table->text('phones')->nullable();
			 $table->text('emails')->nullable();
			 $table->longText('overview')->nullable();
			 $table->string('approximate_employees',100)->nullable();
			 $table->longText('social_urls')->nullable();
			 $table->longText('logo')->nullable();
			 $table->date('lead_date');
			 $table->bigInteger('user_id')->unsigned()->index('leads_user_id_foreign');
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
		$table->dropForeign('leads_user_id_foreign');
        Schema::dropIfExists('leads');
		
    }
}
