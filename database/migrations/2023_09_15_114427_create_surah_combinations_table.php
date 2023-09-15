<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurahCombinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surah_combinations', function (Blueprint $table) {
            $table->id();
            $table->string('surah_id');
            $table->string('sequence');
            $table->string('title');
            $table->integer('type');
            $table->string('translation_count');
            $table->string('tafseer_count');
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
        Schema::dropIfExists('surah_combinations');
    }
}
