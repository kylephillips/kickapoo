<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUploadRelationsToProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('products', function(Blueprint $table)
		{
			$table->integer('image_id')->unsigned()->nullable();
			$table->foreign('image_id')->references('id')->on('uploads')->onDelete('cascade');
			$table->integer('nutrition_label_id')->unsigned()->nullable();
			$table->foreign('nutrition_label_id')->references('id')->on('uploads')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('products', function(Blueprint $table)
		{
			$table->dropColumn('image_id');
			$table->dropColumn('nutrition_label_id');
		});
	}

}
