<?php


namespace KnpU\LoremIpsumBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class WordProviderCompilerPass implements CompilerPassInterface
{
    /**
     * Note: the received container builder has all the services from all the bundles.
     * Note: the code in the compiler pass looks similar to code in the Extension class
     *
     * @param ContainerBuilder $container_builder
     */
    public function process(ContainerBuilder $container_builder)
    {
        $definition = $container_builder->getDefinition('knpu_lorem_ipsum.knpu_ipsum');

        $a_service_references = $this->getReferencesForTaggedServices('knpu_lorem_ipsum_word_provider', $container_builder);

        $definition->setArgument(0, $a_service_references);
    }//end of function


    /*
     * Simply, a convenience method
     */
    private function getReferencesForTaggedServices(string $c_tag_name, ContainerBuilder $container_builder): array
    {
        $a_service_references = [];
        //
        foreach ($container_builder->findTaggedServiceIds($c_tag_name) as $service_id => $a_tag_info) {
            $a_service_references[] = new Reference($service_id);
        }//endforeach

        return $a_service_references;
    }//end of function

}//end of class
