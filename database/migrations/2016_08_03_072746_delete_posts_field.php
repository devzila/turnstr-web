<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePostsField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('media2_thumb_url');
            $table->dropColumn('media3_thumb_url');
            $table->dropColumn('media4_thumb_url');
            $table->dropColumn('media1_url');
            $table->dropColumn('media2_url');
            $table->dropColumn('media3_url');
            $table->dropColumn('media4_url');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('media4_thumb_url')->after('user_id');
            $table->string('media3_thumb_url')->after('user_id');
            $table->string('media2_thumb_url')->after('user_id');
			$table->string('media1_url');
            $table->string('media2_url');
            $table->string('media3_url');
			$table->string('media4_url');
        });
    }
}
