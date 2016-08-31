<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name'        => 'Simon',
            'last_name'         => 'Rapin',
            'company'           => 'LeadSpot',
            'email'             => 'simon.rapin@gmail.com',
            'password'          => '$2y$10$02u7T1no00hXS9xMrZCuUOHO6TV3AXFqQ/wcrH14Y1SBaTZeIUizu',
            'created_at'        => '2016-08-26 16:10:45',
            'updated_at'        => '2016-08-26 16:10:45'
        ]);
    }
}
