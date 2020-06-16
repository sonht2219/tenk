<?php

use App\Enum\Status\LotterySessionStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLotterySessionsTable.
 */
class CreateLotterySessionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    $table = 'lottery_sessions';
		Schema::create($table, function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('product_id')->index();
            $table->bigInteger('time_end')->nullable();
            $table->integer('sold_quantity')->default(0);

            $table->timestamps();

            $table->tinyInteger('status')
                ->default(LotterySessionStatus::SELLING)
                ->comment(generate_db_comment(LotterySessionStatus::getInstances()));
		});

        DB::update("ALTER TABLE $table AUTO_INCREMENT = 1000000;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lottery_sessions');
	}
}
