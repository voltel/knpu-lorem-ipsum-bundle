<?php


namespace KnpU\LoremIpsumBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KnpULoremIpsumExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // voltel: This "strange" code is required to load the config from "Resources/config/services.xml" file
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $a_config_options = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('knpu_lorem_ipsum.knpu_ipsum');

        if (!is_null($a_config_options['word_provider'])) {
            // way 1
            // $definition->setArgument(0, new Reference($config['word_provider']));

            // way 2
            // Instead of changing the argument (as in "way 1"),
            // we can override the alias to point to service id provided by the user.
            // Do this with $container->setAlias()
            $container->setAlias('knpu_lorem_ipsum.word_provider', $a_config_options['word_provider']);
        }//endif

        $definition->setArgument(1, $a_config_options['unicorns_are_real']);
        $definition->setArgument(2, $a_config_options['min_sunshine']);
    }

    public function getAlias()
    {
        return 'knpu_lorem_ipsum';
    }


}