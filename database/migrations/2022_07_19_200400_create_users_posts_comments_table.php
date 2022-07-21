<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPostsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_post_comment', function (Blueprint $table) {
            $table->id();
            $table->text('comment');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->dateTime('date')
                ->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('post_id')
                ->on('posts')
                ->references('id')
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
        Schema::dropIfExists('user_post_comment');
    }
}
