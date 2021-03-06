<?php

namespace KnpU\LoremIpsumBundle\Event;

//use Symfony\Component\EventDispatcher\Event;
//use Symfony\Contracts\EventDispatcher\Event;


// BC hack. Before Symfony 4.3, there was no Event class in Contracts namespace
if (class_exists('Symfony\\Contracts\\EventDispatcher\\Event', false)) {
    class_alias('Symfony\\Contracts\\EventDispatcher\\Event', 'KnpU\\LoremIpsumBundle\\Event\\GenericEvent');
} else {
    class_alias('Symfony\\Component\\EventDispatcher\\Event', 'KnpU\\LoremIpsumBundle\\Event\\GenericEvent');
}

class KnpUApiResponseReadyEvent extends GenericEvent
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
