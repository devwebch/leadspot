<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReportColumnLeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->json('scores')->nullable();
            $table->json('stats')->nullable();
            $table->json('indicators')->nullable();
            $table->json('website')->nullable();
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
            $table->dropColumn('scores');
            $table->dropColumn('stats');
            $table->dropColumn('indicators');
            $table->dropColumn('website');
        });
    }
}
