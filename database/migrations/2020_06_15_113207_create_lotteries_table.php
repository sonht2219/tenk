<?php

use App\Enum\Status\CommonStatus;
use App\Enum\Status\LotteryStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLotteriesTable.
 */
class CreateLotteriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lotteries', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('session_id')->index();
            $table->bigInteger('serial');
            $table->string('user_id')->nullable()->index();

            $table->timestamps();

            $table->tinyInteger('status')
                ->default(LotteryStatus::WAITING)
                ->comment(generate_db_comment(LotteryStatus::getInstances()));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lotteries');
	}
}
