<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = Carbon::now();
        DB::table('users')->insert([[
            'name' => "Admin",
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ], [
            'name' => "Movie User",
            'email' => 'movie_user@gmail.com',
            'password' => bcrypt('123456'),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]]);
    }
}
