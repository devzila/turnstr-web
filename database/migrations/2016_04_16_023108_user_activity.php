<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('follower_id')->comment="user id of follower";
            $table->integer('post_id')->comment="if post is liked";
            $table->integer('liked_id')->comment="user_id of user who like post";
            $table->enum('activity',['follow','liked']);
            $table->integer('status')->default(1);
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
         Schema::drop('user_activity');
    }
}
