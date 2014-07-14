<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('email')->unique();
			$table->string('password');
			$table->integer('group_id')->default(3)->nullable()->unsigned();
			$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
			$table->string('first_name');
			$table->string('last_name');
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
		Schema::drop('users');
	}

}
