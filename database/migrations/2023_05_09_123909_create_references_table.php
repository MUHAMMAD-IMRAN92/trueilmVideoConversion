<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //type = type of referral(1=>ebooks  , 2=>audio book , 3=>ebook)
    //reference_type = type of reference(1=>ebook ,2=>audio , 3=>paper , 4=>Ayat , 5=>Hdith , 6 => Tafseer)
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->id();
            $table->integer('type');
            $table->string('referal_id');
            $table->string('reference');
            $table->integer('reference_type');
            $table->integer('added_by');
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
        Schema::dropIfExists('references');
    }
}
