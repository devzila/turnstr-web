<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateActivityToActivity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_activity', function (Blueprint $table) {
            DB::statement("ALTER TABLE user_activity CHANGE COLUMN activity activity ENUM('follow', 'liked', 'comment')");
			$table->integer('comment_id')->after('post_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_activity', function (Blueprint $table) {
            DB::statement("ALTER TABLE user_activity CHANGE COLUMN activity activity ENUM('follow', 'liked')");
			$table->dropColumn('comment_id');
        });
    }
}
