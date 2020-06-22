<?php

use App\Enum\Status\CommonStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLotteryRewardInfosTable.
 */
class CreateLotteryRewardInfosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lottery_reward_infos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('reward_id');
            $table->string('name');
            $table->string('phone_number');
            $table->string('address');
            $table->integer('province_id');
            $table->integer('district_id');
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
		Schema::drop('lottery_reward_infos');
	}
}
