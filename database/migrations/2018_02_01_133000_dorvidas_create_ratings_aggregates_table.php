<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DorvidasCreateRatingsAggregatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('ratings.database_prefix') . 'rating_aggregates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model', 100)->index();
            $table->unsignedInteger('model_id')->index();
            $table->string('on_model', 100)->index()->nullable();
            $table->unsignedInteger('on_model_id')->index()->nullable();
            $table->string('on_model_column', 50)->nullable();
            $table->double('average', 2, 1)->index();
            $table->unsignedInteger('count')->index();
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
        Schema::dropIfExists(config('ratings.database_prefix') . 'rating_aggregates');
    }
}
