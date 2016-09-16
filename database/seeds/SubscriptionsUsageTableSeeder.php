<?php

use Illuminate\Database\Seeder;

class SubscriptionsUsageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscriptions_usage')->insert([
            'user_id'       => 1,
            'limit'         => 10,
            'used'          => 0,
            'created_at'    => \Carbon\Carbon::now(),
            'updated_at'    => \Carbon\Carbon::now(),
        ]);
    }
}
