<?php

use App\Models\Suitable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuitablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suitables', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });
        $arr = ['Parents', 'Men', 'Women', 'Young Adults', 'Children', 'Adults', 'New Muslims', 'People of Other Faiths', 'Institutions'];
        foreach ($arr as $ar) {

            $suitble = new Suitable();
            $suitble->title =  $ar;
            $suitble->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suitables');
    }
}
