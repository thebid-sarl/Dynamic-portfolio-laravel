<?php

namespace App\Listeners;

use App\Events\VisitorVisited;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Visit;

class LogVisitor
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(VisitorVisited $event): void
    {
        
        Visit::create(['ip_address' => $event->ip]);
    }
}
