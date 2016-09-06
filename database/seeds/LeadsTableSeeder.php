<?php

use Illuminate\Database\Seeder;

class LeadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('leads')->insert(
                [
                    'name'          => 'Shop ' . str_random(5),
                    'url'           => 'http://example.com',
                    'address'       => 'Rue de Genève 7, 1003 Lausanne',
                    'phone_number'  => '021 646 76 23',
                    'notes'         => '',
                    'rating'        => 0,
                    'status'        => 0,
                    'lat'           => 46.5215533,
                    'lng'           => 6.6287104,
                    'user_id'       => 1,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]
            );
        }
    }
}
