<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookMistakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_mistakes', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->integer('book_id');
            $table->integer('user_id');
            $table->integer('page_no')->nullable();
            $table->integer('marked_by')->nullable();
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
        Schema::dropIfExists('book_mistakes');
    }
}
