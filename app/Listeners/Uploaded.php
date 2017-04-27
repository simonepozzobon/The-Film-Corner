<?php

namespace App\Listeners;

use App\Events\NewVideoLibrary;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Uploaded
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
     * @param  NewVideoLibrary  $event
     * @return void
     */
    public function handle(NewVideoLibrary $event)
    {
        dd($event);
    }
}
