<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePhoneCardsTable.
 */
class CreatePhoneCardsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('phone_cards', function(Blueprint $table) {
		    $table->bigIncrements('id');
            $table->string('code', 50)->index();
            $table->string('seri',50)->index();
            $table->tinyInteger('telco');
            $table->integer('value');
            $table->integer('true_value')->nullable();
            $table->integer('card_value')->nullable();
            $table->string('status', 255)->default(config('payment.phone_card.status.cho_duyet'));
            $table->string('transaction_id', 50)->index();
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
		Schema::drop('phone_cards');
	}
}
