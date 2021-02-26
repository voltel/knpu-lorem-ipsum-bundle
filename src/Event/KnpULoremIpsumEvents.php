<?php

namespace KnpU\LoremIpsumBundle\Event;


final class KnpULoremIpsumEvents
{
    /**
     * Note: This is a proper place to document the purpose of this event.
     *
     * This event is dispatched just before the lorem-ipsum API data are returned.
     * Listeners to this event has an opportunity to change/modify data on the event object.
     *
     * @Event("KnpU\LoremIpsumBundle\Event\KnpUApiResponseReadyEvent")
     */
    const API_RESPONSE_READY = 'knpu_lorem_ipsum.api_response_ready';

}