<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutputsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('outputs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('image_url');
			$table->integer('upload_id')->unsigned();
			$table->foreign('upload_id')->references('id')->on('uploads');
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
		Schema::drop('outputs');
	}

}
