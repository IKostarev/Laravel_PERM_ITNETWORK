<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;
use App\Jobs\UserCreatedJob;
use App\Mail\UserCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserCreatedNotification
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
     * @param  Registered|UserCreatedEvent  $event
     * @return void
     */
    public function handle(Registered|UserCreatedEvent $event)
    {
        \Mail::to($event->user)->send(new UserCreated($event->user));
    }
}
