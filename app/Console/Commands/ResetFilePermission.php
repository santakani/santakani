<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetFilePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset-file-permission {user?} {wwwgroup?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if ($this->argument('user')) {
            $user = $this->argument('user');
        } else {
            $user = get_current_user();
        }
        if ($this->argument('wwwgroup')) {
            $wwwgroup = $this->argument('wwwgroup');
        } else {
            $wwwgroup = 'www';
        }

        exec("sudo chown -R $user:$wwwgroup storage public/storage bootstrap/cache");
        exec("sudo chmod -R ug-x+rwX,o-wx+rX storage public/storage bootstrap/cache");
    }
}
