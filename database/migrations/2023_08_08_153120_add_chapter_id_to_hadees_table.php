<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChapterIdToHadeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hadees', function (Blueprint $table) {
            $table->unsignedBigInteger('chapter_id');
            $table->integer('hadees_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hadees', function (Blueprint $table) {
            $table->dropIfExists('chapter_id');
            $table->dropIfExists('hadees_no');
        });
    }
}
