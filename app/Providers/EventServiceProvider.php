<?php

namespace App\Providers;

use Event;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);


        // fired when the token could not be found in the request
        Event::listen('tymon.jwt.absent', function () {
            throw new \App\Exceptions\JWTAbsentException;
        });

        // fired when the token has expired
        Event::listen('tymon.jwt.expired', function () {
            throw new \App\Exceptions\JWTExpiredException;
        });

        // fired when the token is found to be invalid
        Event::listen('tymon.jwt.invalid', function () {
            throw new \App\Exceptions\JWTInvalidException;
        });

        // fired if the user could not be found (shouldn't really happen)
        Event::listen('tymon.jwt.user_not_found', function () {
            throw new \App\Exceptions\JWTUserNotFoundException;
        });
    }
}
