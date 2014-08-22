<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlavorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flavors', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('title');
			$table->integer('order')->default(0);
			$table->string('slug')->unique();
			$table->text('content')->nullable();
			$table->string('image')->nullable();
			$table->string('css_class')->nullable();
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
		Schema::drop('flavors');
	}

}
