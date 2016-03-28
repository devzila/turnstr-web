<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function($table) {
            $table->string('media4_thumb_url')->after('user_id');
            $table->string('media3_thumb_url')->after('user_id');
            $table->string('media2_thumb_url')->after('user_id');
            $table->string('media1_thumb_url')->after('user_id');
            $table->string('caption')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function($table) {
            $table->dropColumn('media4_thumb_url');
            $table->dropColumn('media3_thumb_url');
            $table->dropColumn('media2_thumb_url');
            $table->dropColumn('media1_thumb_url');
            $table->dropColumn('caption');
        });

    }
}
