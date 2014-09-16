<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptInToForms extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('forms', function(Blueprint $table)
		{
			$table->integer('email_opt_in')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('forms', function(Blueprint $table)
		{
			$table->dropColumn('email_opt_in');
		});
	}

}
