<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('place_id')->nullable();
            $table->integer('user_id');
            $table->string('name');
            $table->string('url')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('cms', 20)->nullable();
            $table->text('notes')->nullable();
            $table->float('lat', 10, 8)->nullable();
            $table->float('lng', 11, 8)->nullable();
            $table->tinyInteger('rating');
            $table->tinyInteger('status');
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
        Schema::table('leads', function (Blueprint $table) {
            Schema::drop('leads');
        });
    }
}
