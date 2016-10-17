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

            foreach ($usages as $item) {
                $quotas = [
                    'search'    => ['limit' => $item->limit, 'used' => $item->used],
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
