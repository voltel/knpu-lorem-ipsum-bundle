<?php


namespace KnpU\LoremIpsumBundle\Tests\Controller;


use KnpU\LoremIpsumBundle\KnpULoremIpsumBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

use function Tests\Lib\Functions\delete_files;

class IpsumApiControllerTest extends TestCase
{
    const CACHE_DIR = __DIR__ . '/../var/cache/test';

    protected function tearDown(): void
    {
        // delete cache with a cached kernel - the kernel needs to be re-created for each test "from scratch"
        delete_files(self::CACHE_DIR);
    }


    public function test_api_index()
    {
        $kernel = new KnpULoremIpsumApiControllerKernel();
        $kernel->boot();

        $browserClient = new KernelBrowser($kernel);

        $browserClient->request('GET', '/api/');

        //var_dump($browserClient->getResponse()->getContent());

        $this->assertSame(200, $browserClient->getResponse()->getStatusCode());

    }


}//end of class



class KnpULoremIpsumApiControllerKernel extends Kernel
{
    // Note: This trait will invoke "registerContainerConfiguration" method inside
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }

    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->import(__DIR__ . '/../../src/Resources/config/routes.xml', '/api');

    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $container->loadFromExtension('framework', [
            // 'secret' => '323afc43a4',
            //'routing' => ['utf8' => true],
        ]);
    }


    /**
     * @inheritDoc
     */
    public function registerBundles()
    {
        return [
            new KnpULoremIpsumBundle(),
            new FrameworkBundle(),
        ];
    }

//    /**
//     * Note: With MicroKernelTrait this method should NOT be used
//     * @inheritDoc
//     */
//    public function registerContainerConfiguration(LoaderInterface $loader)
//    {
//        $loader->load(function (ContainerBuilder $container) use ($loader) {
//            //
//        });
//    }//end of function


    public function getCacheDir()
    {
        return __DIR__ . '/../../var/cache/test/' . spl_object_hash($this);
        //return parent::getCacheDir();
    }


}//end of class
