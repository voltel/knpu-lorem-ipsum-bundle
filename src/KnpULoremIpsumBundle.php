<?php

namespace KnpU\LoremIpsumBundle;

use KnpU\LoremIpsumBundle\DependencyInjection\Compiler\WordProviderCompilerPass;
use KnpU\LoremIpsumBundle\DependencyInjection\KnpULoremIpsumExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KnpULoremIpsumBundle extends Bundle
{
    // voltel: You almost never have to have any logic in here


    /**
     * Note: adds compiler pass ("WordProviderCompilerPass") to locate all tagged services and
     * add an array of references to them as a first argument to the definition of 'knpu_lorem_ipsum.knpu_ipsum' service.
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        // There are different types of compiler passes,
        // which determine when they are executed relative to other passes.
        // And, there's also a priority.
        $container->addCompilerPass(new WordProviderCompilerPass());
    }


    public function getContainerExtension()
    {
        // voltel: this overrides the parent implementation of this method
        if (is_null($this->extension)) {
            $this->extension = new KnpULoremIpsumExtension();
        }

        return $this->extension;
    }


}