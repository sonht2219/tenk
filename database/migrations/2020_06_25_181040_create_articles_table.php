<?php

use App\Enum\Status\CommonStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateArticlesTable.
 */
class CreateArticlesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug', 191)->unique();
            $table->string('description');
            $table->string('author');
            $table->text('content');
            $table->string('thumbnail');
            $table->integer('seen')->default(0);
            $table->string('created_by_id')->index();

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
		Schema::drop('articles');
	}
}
