<?php

use App\Enum\DepositChannel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionCashDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_cash_details', function (Blueprint $table) {
            $table->string('transaction_id')->primary();
            $table->bigInteger('value_original');
            $table->tinyInteger('deposit_channel')
                ->comment(generate_db_comment(DepositChannel::getInstances()));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_cash_details');
    }
}
