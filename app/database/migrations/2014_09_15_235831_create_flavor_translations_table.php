<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlavorTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flavor_translations', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('parent_flavor')->unsigned();
			$table->integer('translated_flavor')->unsigned();
			$table->timestamps();
			$table->foreign('parent_flavor')->references('id')->on('flavors')->onDelete('cascade');
			$table->foreign('translated_flavor')->references('id')->on('flavors')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('flavor_translations');
	}

}
