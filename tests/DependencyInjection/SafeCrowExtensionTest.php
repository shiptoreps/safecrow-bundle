<?php

namespace SafeCrowBundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use SafeCrow\Client;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class SafeCrowExtensionTest
 * @package SafeCrowBundle\DependencyInjection
 */
class SafeCrowExtensionTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * @var SafeCrowExtension
     */
    protected $extension;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new SafeCrowExtension();
    }

    /**
     * @throws \Exception
     */
    public function testCreateClients()
    {
        $config = [
            'safe_crow' => [
                'clients' => [
                    'first' => [
                        'key' => 'NPKCXY14MTWAITU6PI6O',
                        'secret' => 'AYFVW0TC9MOVENS005VA'
                    ],
                    'second' => [
                        'key' => '8VO9T6AFCJ072GPUTZU4',
                        'secret' => 'SC14UAFN2EU3HX1XS7DR',
                        'dev' => true,
                    ],
                    'three' => [
                        'key' => 'XO90UCM201H5GPI3O5AM',
                        'secret' => 'XS4H4M4BK4U8L2EUFR6Q',
                        'dev' => false,
                    ],
                ],
            ],
        ];

        $this->extension->load($config, $this->container);

        $this->assertTrue($this->container->has('safe_crow.client.first'));
        $this->assertTrue($this->container->has('safe_crow.client.second'));
        $this->assertTrue($this->container->has('safe_crow.client.three'));

        $this->assertInstanceOf(Client::class, $this->container->get('safe_crow.client.first'));
        $this->assertInstanceOf(Client::class, $this->container->get('safe_crow.client.second'));
        $this->assertInstanceOf(Client::class, $this->container->get('safe_crow.client.three'));
    }
}
