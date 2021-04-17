<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('post_comment', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('parent_id');
			$table->integer('child_id');
			$table->string('source', 10);

			$table->index(['parent_id', 'child_id']);
		});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('post_comment');
    }
}
