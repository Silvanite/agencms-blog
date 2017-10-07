<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('published')->default(false);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('blog_article_blog_category', function (Blueprint $table) {
            $table->integer('blog_article_id')->unsigned();
            $table->integer('blog_category_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('blog_article_blog_category', function (Blueprint $table) {
            $table->foreign('blog_article_id')
                  ->references('id')
                  ->on('blog_articles')
                  ->onDelete('cascade');
        
            $table->foreign('blog_category_id')
                  ->references('id')
                  ->on('blog_categories')
                  ->onDelete('cascade');

            $table->primary(['blog_article_id', 'blog_category_id'], 'blog_category_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_article_blog_category');
        Schema::dropIfExists('blog_categories');
    }
}
