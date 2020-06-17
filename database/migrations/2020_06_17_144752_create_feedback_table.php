<?php

use App\Enum\Status\CommonStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFeedbackTable.
 */
class CreateFeedbackTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feedback', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('session_id')->index();
            $table->string('user_id')->index();
            $table->integer('product_id')->index();
            $table->bigInteger('lottery_id')->index();

            $table->text('content');
            $table->text('images')->nullable();
            $table->tinyInteger('status')
                ->default(CommonStatus::ACTIVE)
                ->comment(generate_db_comment(CommonStatus::getInstances()));

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
		Schema::drop('feedback');
	}
}
