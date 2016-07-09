<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;

/**
 * Set user role.
 */
class UserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role {user : ID of the user} {role : New role of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the role of a user.';

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
        $user = User::find($this->argument('user'));
        $user->role = $this->argument('role');
        $user->save();
    }
}
