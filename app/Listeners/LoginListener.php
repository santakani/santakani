<?php

namespace App\Listeners;

use App\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $ip = request()->ip();
        $client = 'web';

        ActivityLog::create([
            'action' => 'login',
            'message' => "<a href=\"{$event->user->url}\">{$event->user->name}</a> logged in.",
            'metadata' => json_encode([
                'remember' => $event->remember,
                'ip' => $ip,
                'client' => $client,
            ]),
            'level' => 50,
            'user_id' => $event->user->id,
        ]);
    }
}
