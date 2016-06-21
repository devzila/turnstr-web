<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetUsernameNonUniqueOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement('ALTER TABLE users CHANGE username username VARCHAR(20) NULL DEFAULT NULL');
            DB::statement('ALTER TABLE users CHANGE email email VARCHAR(255) NULL DEFAULT NULL');
            DB::statement('ALTER TABLE users CHANGE following following INT(11) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE users CHANGE followers followers INT(11) NOT NULL DEFAULT 0');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
