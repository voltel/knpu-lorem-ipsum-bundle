<?php


namespace KnpU\LoremIpsumBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private $debug;

    public function __construct($debug)
    {
        $this->debug = (bool) $debug;
    }

    // See an example at: "vendor\symfony\framework-bundle\DependencyInjection\Configuration.php"
    public function getConfigTreeBuilder()
    {
        list($treeBuilder, $rootNode) = $this->getRootNode();

        $rootNode
            ->children()
                ->booleanNode('unicorns_are_real')
                ->defaultValue($this->debug)
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

    /**
     * voltel: This is an attempt to provide compatibility for versions of Symfony
     *
     * Note: This is just a convenience method.
     * Returns an array with two values: treeBuilder and rootNode
     *
     * @return array
     * @throws \ReflectionException
     */
    private function getRootNode() : array
    {
        $oReflectionClass = new \ReflectionClass(TreeBuilder::class);

        if ($oReflectionClass->hasMethod('__construct')
            && $oReflectionClass->hasMethod('getRootNode')
        ) {
            // Symfony >= 4.3
            $treeBuilder = new TreeBuilder('knpu_lorem_ipsum');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // Symfony < 4.3
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('knpu_lorem_ipsum');
        }//endif

        return [$treeBuilder, $rootNode];
    }//end of function

}