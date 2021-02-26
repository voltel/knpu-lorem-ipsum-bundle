<?php

namespace KnpU\LoremIpsumBundle\Event;


use Symfony\Component\EventDispatcher\Event;

class KnpUApiResponseReadyEvent extends Event
{
    const EVENT_NAME = KnpULoremIpsumEvents::API_RESPONSE_READY;

    /** @var array */
    private $data;

    public function __construct(array $a_data)
    {
        $this->data = $a_data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $a_data)
    {
        $this->data = $a_data;
    }

    public function getEventName() : string
    {
        return self::EVENT_NAME;
    }

}
