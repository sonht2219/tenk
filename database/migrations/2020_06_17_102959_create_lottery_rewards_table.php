<?php

use App\Enum\Status\CommonStatus;
use App\Enum\Status\RewardStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLotteryRewardsTable.
 */
class CreateLotteryRewardsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lottery_rewards', function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('session_id')->index();
            $table->string('user_id')->index();
            $table->bigInteger('lottery_id')->index();
            $table->integer('join_times')->comment('Số lần tham dự');

            $table->timestamps();

            $table->tinyInteger('status')
                ->default(RewardStatus::PROCESSING)
                ->comment(generate_db_comment(RewardStatus::getInstances()));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lottery_rewards');
	}
}
