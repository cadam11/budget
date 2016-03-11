<?php

namespace Budget\Console\Commands;

use Budget\User;
use Illuminate\Console\Command;

class RemoveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:remove {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the user identified by {email}';

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
        $email = $this->argument('email');
        if (!$email) {        
            $email = $this->ask('Email: ');
        }

        $results = User::where('email', $email)->get();
        
        if ($results->count() > 0) {
            $user = $results->first();
            $this->info("Found user '$user'.");
            if ($this->confirm('Do you wish to delete this user? [y|N]')) {
                $user->delete();
                $this->info("User deleted.");
            }

        } else {
            $this->error('No user was found with that email.');
        }

    }
}
