<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsizesTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('productsizes_translations', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('parent_size')->unsigned();
			$table->integer('translated_size')->unsigned();
			$table->timestamps();
			$table->foreign('parent_size')->references('id')->on('productsizes')->onDelete('cascade');
			$table->foreign('translated_size')->references('id')->on('productsizes')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('productsizes_translations');
	}

}
