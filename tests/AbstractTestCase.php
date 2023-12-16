<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symplify\ConfigTransformer\Kernel\ConfigTransformerContainerFactory;

abstract class AbstractTestCase extends TestCase
{
    private ContainerInterface $container;

    protected function setUp(): void
    {
        $configTransformerContainerFactory = new ConfigTransformerContainerFactory();
        $this->container = $configTransformerContainerFactory->create();
    }

    /**
     * @template T as object
     *
     * @param class-string<T> $type
     * @return T
     */
    protected function getService(string $type): object
    {
        return $this->container->get($type);
    }
}
