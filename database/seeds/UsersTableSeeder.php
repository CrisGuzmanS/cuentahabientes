<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            [
                'name' => 'Cristian Guzmán Suárez',
                'email' => 'cristian@mail.com',
                'type' => 'Administrator',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'Irving Samaniego',
                'email' => 'irving@mail.com',
                'type' => 'Administrator',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'Yareli Elizabeth Gomez',
                'email' => 'yare@mail.com',
                'type' => 'Administrator',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'Diana Hernandez',
                'email' => 'diana@mail.com',
                'type' => 'Administrator',
                'password' => bcrypt('123456'),
            ]
        ]);
    }
}
