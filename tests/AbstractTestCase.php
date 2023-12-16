<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symplify\ConfigTransformer\Kernel\ConfigTransformerKernel;

abstract class AbstractTestCase extends TestCase
{
    private ContainerInterface $container;

    protected function setUp(): void
    {
        $configTransformerKernel = new ConfigTransformerKernel();
        $configTransformerKernel->boot();

        $this->container = $configTransformerKernel->getContainer();
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
