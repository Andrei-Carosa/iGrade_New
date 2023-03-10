<?php

namespace App\Providers;

use App\Events\AddColumn;
use App\Events\ViewClassRecord;
use App\Events\ViewFRS;
use App\Listeners\AddClassRecordGrade;
use App\Listeners\AddColumnScore;
use App\Listeners\AddStudentGrade;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ViewFRS::class =>[
            AddStudentGrade::class,
        ],
        ViewClassRecord::class=>[
            AddClassRecordGrade::class,
        ],
        AddColumn::class=>[
            AddColumnScore::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
