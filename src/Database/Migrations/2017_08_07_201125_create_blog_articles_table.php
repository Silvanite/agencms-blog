<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('title')->nullable();
            $table->string('preview_title')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->date('published')->nullable();
            $table->date('expires')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('author')->unsigned();
            $table->timestamps();
        });

        Schema::table('blog_articles', function (Blueprint $table) {
            $table->foreign('author')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_articles');
    }
}
