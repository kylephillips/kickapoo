<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUploadIdToFlavors extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('flavors', function(Blueprint $table)
		{
			$table->integer('upload_id')->unsigned()->nullable();
			$table->foreign('upload_id')->references('id')->on('uploads')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('flavors', function(Blueprint $table)
		{
			$table->dropColumn('upload_id');
		});
	}

}
