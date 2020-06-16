<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateWalletLogsTable.
 */
class CreateWalletLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wallet_logs', function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('user_id')->index();
            $table->integer('wallet_id')->index();
            $table->bigInteger('cash_changed');
            $table->bigInteger('old_cash');
            $table->bigInteger('new_cash');
            $table->text('reason');
            $table->string('ref_table', 50)->nullable();
            $table->string('ref_index', 191)->nullable();

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
		Schema::drop('wallet_logs');
	}
}
