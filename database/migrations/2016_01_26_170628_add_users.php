<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->whereIn('email', ['craig@adam11.ca','karen@adam11.ca'])->delete();
    }
}
