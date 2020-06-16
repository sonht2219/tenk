<?php

use App\Enum\Status\CommonStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateProductsTable.
 */
class CreateProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
            $table->increments('id');

            $table->string('name', 191);
            $table->string('slug', 191)->unique();
            $table->text('description');
            $table->text('images');
            $table->string('thumbnail');

            $table->integer('price');
            $table->bigInteger('original_price');

            $table->string('creator_id')->index();

            $table->timestamps();
            $table->tinyInteger('status')
                ->default(CommonStatus::ACTIVE)
                ->comment(generate_db_comment(CommonStatus::getInstances()));
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
