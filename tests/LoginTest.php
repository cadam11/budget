<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Tests login functions
 */
class LoginTest extends TestCase
{
    /**
     * Basic login
     *
     * @return void
     */
    public function it_logs_in_properly()
    {
    	// set up
    	// 
    	// a valid user in the database
    	$password = "bamboo";
		$user = factory(Budget\User::class)->create();
		$user->password = bcrypt($password);
		$user->save();

    	// execute
    	// 
    	// visit the login page
        // enter credentials
        $this->visit('/login')
        	->type($user->email, "email")
        	->type($password, "password")
        	->press('Login')

    	// test assertions
    	// 
    	// the http response was as expected
	    	->seePageIs('/')
	    	->see($user->name);    	
    }
}
