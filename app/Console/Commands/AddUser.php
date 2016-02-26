<?php

namespace Budget\Console\Commands;

use Illuminate\Console\Command;
use Budget\User;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('Display name: ');
        $email = $this->ask('Email: ');
        $min_length = 10;
        $length = 0;
        $password = $confirm = "";

        $user = User::firstOrNew(['email' => $email]);

        if ($user->exists){
            
            $this->error("A user with that email address already exists.");

        } else {

            while (true){
                
                $password = $this->secret('Desired password: ');

                $length = strlen($password);
                if ($length < $min_length) {
                    $this->error("Password too short, must be at least $min_length characters.");
                } else {
                    $confirm = $this->secret('Confirm password: ');
                    if ($password != $confirm) {
                        $this->error("Passwords do not match.");
                    } else {
                        break;
                    }
                }
            }            

            $user->name = $name;
            $user->password = bcrypt($password);
            $user->save();
            $this->info("User added.");
        }

    }
}
