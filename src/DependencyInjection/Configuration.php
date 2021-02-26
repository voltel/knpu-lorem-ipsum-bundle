<?php


namespace KnpU\LoremIpsumBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    // See an example at: "vendor\symfony\framework-bundle\DependencyInjection\Configuration.php"
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('knpu_lorem_ipsum');

        $rootNode
            ->children()
                ->scalarNode('word_provider')
                ->defaultNull()
                ->info('Define word provider to replace the default')
            ->end()
                ->booleanNode('unicorns_are_real')
                ->defaultTrue()
               ->info('Whether you believe in unicorns or not')
            ->end()
                ->integerNode('min_sunshine')
                ->defaultValue(3)
                ->info('Min count of times the word "shunshine" should appear in a paragraph. ')
            ->end()
        ->end()
        ;

        return $treeBuilder;
    }

}