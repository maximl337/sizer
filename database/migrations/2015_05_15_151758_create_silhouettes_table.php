<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSilhouettesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('silhouettes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('image_url');
			$table->decimal('max_height_cm', 18, 2)->unsigned();
			$table->decimal('max_width_cm', 18, 2)->unsigned();
			$table->integer('offset_height_px')->unsigned();
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
		Schema::drop('silhouettes');
	}

}
