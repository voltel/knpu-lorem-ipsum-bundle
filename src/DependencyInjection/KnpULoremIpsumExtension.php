<?php


namespace KnpU\LoremIpsumBundle\DependencyInjection;


use KnpU\LoremIpsumBundle\WordProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Read at: https://symfony.com/doc/current/bundles/extension.html
 */
class KnpULoremIpsumExtension extends Extension
{
    /**
     * Note: The container builder is empty at the beginning of this method.
     * There are no services in it, so we can't use "findTaggedServiceIds()" method to locate tagged services.
     * See the Bundle class for compiler pass.
     *
     * Note: This container only has the parameters from the actual container.
     *
     * Note: The invocation of "processConfiguration()" method inside
     * will return one aggregated config for this environment from all located configs (array of arrays),
     * and it will be validated by rules of Configuration class.
     *
     * @param array $configs
     * @param ContainerBuilder $container_builder
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container_builder)
    {
        // voltel: This "strange" code is required to load the config from "src/Resources/config/services.xml" file
        $loader = new XmlFileLoader($container_builder, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');


        // Read at: https://symfony.com/doc/current/bundles/configuration.html#processing-the-configs-array
        // $configuration_tree_rules = new Configuration();
        $configuration_tree_rules = $this->getConfiguration($configs, $container_builder);
        $a_config_options = $this->processConfiguration($configuration_tree_rules, $configs);

        $definition = $container_builder->getDefinition('knpu_lorem_ipsum.knpu_ipsum');

        $definition->setArgument(1, $a_config_options['unicorns_are_real']);
        $definition->setArgument(2, $a_config_options['min_sunshine']);

        // This will later result in a tag "knpu_lorem_ipsum_word_provider"
        // being added to all services in the container which implement interface "WordProviderInterface".
        // This tag is used by compiler pass to gather references to tagged services and modify our service definition.
        $container_builder->registerForAutoconfiguration(WordProviderInterface::class)
            ->addTag('knpu_lorem_ipsum_word_provider');

        // Add classes with annotations to be compiled.
        // Read at: https://symfony.com/doc/current/bundles/extension.html#adding-classes-to-compile
        //$this->addAnnotatedClassesToCompile([/**/])
    }//end of function


    /**
     * Read at: https://symfony.com/doc/current/configuration/using_parameters_in_dic.html
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        $l_debug = $container->getParameter('kernel.debug');
        // custom argument to my class constructor - boolean indicating a "debug" mode
        return new Configuration($l_debug);
    }

    /**
     * This will be used as an alias for the bundle, as shown e.g. by running in terminal "php bin/console config:dump"
     * By default, the parent implementation would produce the following alias: "knp_u_lorem_ipsum"
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