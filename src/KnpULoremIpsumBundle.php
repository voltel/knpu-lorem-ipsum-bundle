<?php

namespace KnpU\LoremIpsumBundle;

use KnpU\LoremIpsumBundle\DependencyInjection\KnpULoremIpsumExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KnpULoremIpsumBundle extends Bundle
{
    // voltel: You almost never have to have any logic in here

    public function getContainerExtension()
    {
        // voltel: this overrides the parent implementation of this method
        if (is_null($this->extension)) {
            $this->extension = new KnpULoremIpsumExtension();
        }

        return $this->extension;
    }


}