<?php

use App\Enum\Status\CommonStatus;
use App\Enum\Type\UserAddressType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->index();
            $table->string('name');
            $table->string('phone_number');
            $table->string('address');
            $table->integer('province_id');
            $table->integer('district_id');
            $table->tinyInteger('type')->default(UserAddressType::NORMAL)
                ->comment(generate_db_comment(UserAddressType::getInstances()));
            $table->tinyInteger('status')->default(CommonStatus::ACTIVE)
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
        Schema::dropIfExists('user_addresses');
    }
}
