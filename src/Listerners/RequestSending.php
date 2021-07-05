<?php

namespace Teknasyon\Suite\Listeners;

use Illuminate\Http\Client\Events\RequestSending as RequestSendingEvent;

class RequestSending
{

    /**
     * @param RequestSendingEvent $event
     */
    public function handle(RequestSendingEvent $event)
    {
        $reg = $event->request;
        // $reg->request->add();
    }
}
