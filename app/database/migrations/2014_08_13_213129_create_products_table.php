<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('flavor_id')->unsigned()->nullable();
			$table->foreign('flavor_id')->references('id')->on('flavors');
			$table->integer('size_id')->unsigned()->nullable();
			$table->foreign('size_id')->references('id')->on('productsizes');
			$table->text('ingredients')->nullable();
			$table->string('nutrition_label')->nullable();
			$table->text('content')->nullable();
			$table->string('image')->nullable();
			$table->integer('order')->default(0)->nullable();
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
		Schema::drop('products');
	}

}
