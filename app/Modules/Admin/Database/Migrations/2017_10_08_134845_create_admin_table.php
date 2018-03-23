<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Location table
        Schema::create('huge__locations', function (Blueprint $table) {
            $table->integer('location_id')->unsigned();
            $table->string('name', 40);
            $table->integer('parent_id');
            $table->string('short_name', 40);
            $table->integer('level_type');
            $table->string('city_code', 20);
            $table->string('zip_code', 20);
            $table->string('merge_name', 100);
            $table->float('lng', 16, 8);
            $table->float('lat', 16, 8);
            $table->string('pinyin', 100);

            $table->primary('location_id');
            // Set foreign key constraints
        });

        // Admin table
        Schema::create('huge__admin', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20)->unqiue();
            $table->string('password', 256);
            $table->string('email', 128)->nullable();
            $table->string('cell', 11);
            $table->integer('country')->unsigned();
            $table->integer('province')->unsigned();
            $table->integer('city')->unsigned();
            $table->integer('district')->unsigned()->nullable();
            $table->integer('division')->unsigned()->comment('所属赛区');
            $table->tinyInteger('suspended')->default(false);
            $table->rememberToken();
            $table->timestamps();

            // Set foreign key constraints
            $table->foreign('country')->references('location_id')->on('huge__locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('province')->references('location_id')->on('huge__locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('city')->references('location_id')->on('huge__locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('district')->references('location_id')->on('huge__locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('division')->references('location_id')->on('huge__locations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        // Contestants table
        Schema::create('huge__contestants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fName', 32);
            $table->string('lName', 12);
            $table->string('mName', 12);
            $table->string('cell', 11); // TODO: 该号码用于选手自主首次登录后台匹配Editor角色的key
            $table->integer('age');
            $table->enum('sex', ['m','f'])->default('m');
            $table->string('wechat_id', 256)->nullable();
            $table->string('open_id', 256)->nullable();
            $table->integer('country')->unsigned()->comment('来自国家');
            $table->integer('province')->unsigned()->comment('来自省');
            $table->integer('city')->unsigned()->comment('来自市');
            $table->integer('height')->comment('身高cm');
            $table->integer('weight')->comment('体重kg');
            $table->integer('bust')->comment('胸围');
            $table->integer('waistline')->comment('腰围');
            $table->integer('hipline')->comment('臀围');
            $table->text('tags')->nullable()->comment('json格式的标签');
            $table->text('intro')->comment('自我介绍');
            $table->timestamps();

            // Set foreign constraints
            $table->foreign('country')->references('location_id')->on('huge__locations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('province')->references('location_id')->on('huge__locations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('city')->references('location_id')->on('huge__locations')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        // Votes table
        Schema::create('huge__votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contestant_id')->unsigned()->comment('选手ID');
            $table->integer('voter_id')->comment('投票人ID');
            $table->integer('count')->comment('单个投票人对单个选手的投票数量，每个投票人每天针对同一个选手限投5票');
            $table->timestamps();

            $table->foreign('contestant_id')->references('id')->on('huge__contestants')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('huge__admin');
        Schema::dropIfExists('huge__locations');
        Schema::dropIfExists('huge__contestants');
        Schema::dropIfExists('huge__votes');
    }
}
