<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \App\User::create([
           'name' => 'test',
           'email' => 'test@test.fr',
           'password' => bcrypt('test'),
       ]);
    }
}
