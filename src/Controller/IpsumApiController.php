<?php

namespace KnpU\LoremIpsumBundle\Controller;

use KnpU\LoremIpsumBundle\Event\KnpUApiResponseReadyEvent;
use KnpU\LoremIpsumBundle\KnpUIpsum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class IpsumApiController extends AbstractController
{
    private $knpUIpsum;
    private $eventDispatcher;

    public function __construct(
        KnpUIpsum $knpUIpsum,
        EventDispatcherInterface $eventDispatcher = null
    )
    {
        $this->knpUIpsum = $knpUIpsum;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function api_index(Request $request)
    {
        $n_words_count = $request->get('words', 6);
        $n_sentences_count = $request->get('sentences', 2);
        $n_paragraphs_count = $request->get('paragraphs', 1);

        $a_data = [
            'words' => $this->knpUIpsum->getWords($n_words_count),
            'sentences' => $this->knpUIpsum->getSentences($n_sentences_count),
            'paragraphs' => $this->knpUIpsum->getParagraphs($n_paragraphs_count),
        ];

        if ($this->eventDispatcher) {
            $event = new KnpUApiResponseReadyEvent($a_data);

            /** @noinspection PhpMethodParametersCountMismatchInspection */
            $this->eventDispatcher->dispatch($event->getEventName(), $event);

            $a_data = $event->getData();
        }//endif


        return $this->json($a_data);
    }//end of function

}//end of class
