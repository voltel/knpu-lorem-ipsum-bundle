<?php


namespace KnpU\LoremIpsumBundle\DependencyInjection;


use KnpU\LoremIpsumBundle\WordProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KnpULoremIpsumExtension extends Extension
{
    /**
     * Note: The container builder is empty at the beginning of this method.
     * There are no services in it, so we can't use "findTaggedServiceIds()" method to locate tagged services.
     * See the Bundle class for compiler pass.
     *
     * @param array $configs
     * @param ContainerBuilder $container_builder
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container_builder)
    {
        // voltel: This "strange" code is required to load the config from "Resources/config/services.xml" file
        $loader = new XmlFileLoader($container_builder, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container_builder);
        $a_config_options = $this->processConfiguration($configuration, $configs);

        $definition = $container_builder->getDefinition('knpu_lorem_ipsum.knpu_ipsum');

        $definition->setArgument(1, $a_config_options['unicorns_are_real']);
        $definition->setArgument(2, $a_config_options['min_sunshine']);

        // This will later result in a tag needed by compiler pass
        // being added to all services which implement this interface:
        $container_builder->registerForAutoconfiguration(WordProviderInterface::class)
            ->addTag('knpu_lorem_ipsum_word_provider');
    }

    /**
     * This will be used as an alias for the bundle, as shown e.g. by running in terminal "php bin/console config:dump
     *  ---------------------------- ------------------------
     *   Bundle name                  Extension alias
     *  ---------------------------- ------------------------
     *   KnpULoremIpsumBundle         knpu_lorem_ipsum
     *
     * @return string
     */
    public function getAlias()
    {
        return 'knpu_lorem_ipsum';
    }


}