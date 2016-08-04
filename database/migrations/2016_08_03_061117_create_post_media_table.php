<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_media', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('post_id')->unsigned()->index();
			$table->string('media_url', 255);
			$table->string('media_thumb_url', 255);
			$table->enum('media_type', ['image','video']);			
			$table->timestamps();
			$table->foreign('post_id')
					->references('id')->on('posts')->onDelete('cascade');
				
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post_media');
    }
}
