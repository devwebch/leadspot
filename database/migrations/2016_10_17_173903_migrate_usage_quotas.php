<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateUsageQuotas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions_usage', function (Blueprint $table) {
            $usages = DB::table('subscriptions_usage')->get();
            $search_free_limit = config('subscriptions.free.limit.search');

            foreach ($usages as $item) {
                $limit = ($item->limit < $search_free_limit) ? $search_free_limit : $item->limit;
                $quotas = [
                    'search'    => ['limit' => $limit, 'used' => 0],
                    'contacts'  => ['limit' => config('subscriptions.free.limit.contacts'), 'used' => 0]
                ];
                $quotas = json_encode($quotas);

                DB::table('subscriptions_usage')->where('id', $item->id)->update(['quotas' => $quotas]);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions_usage', function (Blueprint $table) {
            //
        });
    }
}
