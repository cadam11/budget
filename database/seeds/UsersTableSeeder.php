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
                [
                    'name' => 'Craig',
                    'email' => 'craig@adam11.ca',
                    'password' => '$2y$10$E9xC1b6EC9kUdHQOPx/6yuVRZZ/W0qCMVAPI9UiOw7adzeyPLaUoq',
                ],
                [
                    'name' => 'Karen',
                    'email' => 'karen@adam11.ca',
                    'password' => '$2y$10$xlLhBfTO/6w4ypLHfCMR/OoLE7tE05YtSNeaKptH7GVzP.5fdk3LK',
                ],
            ]);
    }
}
