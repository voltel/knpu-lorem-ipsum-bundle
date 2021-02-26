<?php

namespace KnpU\LoremIpsumBundle\Tests;

use KnpU\LoremIpsumBundle\KnpUIpsum;
use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use KnpU\LoremIpsumBundle\WordProviderInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

use function Tests\Lib\Functions\ {delete_files, delete_files_recursive};

class FunctionalTest extends TestCase
{
    const CACHE_DIR = __DIR__ . '/../var/cache/test';

    protected function tearDown(): void
    {
        // delete cache with a cached kernel - the kernel needs to be re-created for each test "from scratch"
        delete_files(self::CACHE_DIR);
    }

    /**
     * @test
     */
    public function testServiceWiring()
    {
        $kernel = new KnpULoremIpsumTestingKernel();
        $kernel->boot();
        $container = $kernel->getContainer();

        $ipsum = $container->get('knpu_lorem_ipsum.knpu_ipsum');
        //$ipsum = $container->get('Test\App\Service\KnpUIpsum');

        $this->assertInstanceOf(KnpUIpsum::class, $ipsum);
        $this->assertIsString($ipsum->getParagraphs());

    }//end of function


    /**
     * @test
     */
    public function testServiceWiringWithConfiguration()
    {
        $kernel = new KnpULoremIpsumTestingKernel([
            // array version of your YAML config
            'min_sunshine' => 2,
            'word_provider' => 'fake_word_provider',
        ]);

        $kernel->boot();
        $container = $kernel->getContainer();

        /** @var KnpUIpsum $ipsum */
        $ipsum = $container->get('knpu_lorem_ipsum.knpu_ipsum');
        //$ipsum = $container->get('Test\App\Service\KnpUIpsum');

        $c_text = $ipsum->getWords(2);

        $this->assertStringContainsString('stub', $c_text);
    }//end of function

}//end of class



class KnpULoremIpsumTestingKernel extends Kernel
{
    /**
     * @var array
     */
    private $aKnpuLoremIpsumConfig;

    public function __construct($a_knpu_lorem_ipsum_config = [])
    {
        parent::__construct('test', true);

        $this->aKnpuLoremIpsumConfig = $a_knpu_lorem_ipsum_config;
    }

    /**
     * @inheritDoc
     */
    public function registerBundles()
    {
        return [
            new KnpULoremIpsumBundle(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) use ($loader) {
            // This fake service id is used in "testServiceWiringWithConfiguration" and is set here:
            $container->register('fake_word_provider', FakeWordProvider::class);

            $container->loadFromExtension('knpu_lorem_ipsum', $this->aKnpuLoremIpsumConfig);
        });
    }//end of function


    public function getCacheDir()
    {
        return __DIR__ . '/../var/cache/test/' . spl_object_hash($this);
        //return parent::getCacheDir();
    }


}//end of class



class FakeWordProvider implements WordProviderInterface
{
    public function getWordList(): array
    {
        return ['stub', 'stub2'];
    }
}
