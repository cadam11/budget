<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Tests login functions
 */
class LoginTest extends TestCase
{
    public function test_it_logs_in_properly()
    {
    	$password = "bamboo";
		$user = factory(Budget\User::class)->create();
		$user->password = bcrypt($password);
		$user->save();

        $this->visit('/login')
        	->type($user->email, "email")
        	->type($password, "password")
        	->press('Login');

    	$this
	    	->seePageIs('/')
	    	->see($user->name);    	
    }
}
