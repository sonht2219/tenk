<?php

use App\Enum\Status\CommonStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBannerTypesTable.
 */
class CreateBannerTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banner_types', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
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
		Schema::drop('banner_types');
	}
}
