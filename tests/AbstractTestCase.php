<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests;

use PHPUnit\Framework\TestCase;
use Symplify\ConfigTransformer\Kernel\ConfigTransformerKernel;

abstract class AbstractTestCase extends TestCase
{
    protected \Symfony\Component\DependencyInjection\ContainerInterface $container;

    protected function setUp(): void
    {
        $configTransformerKernel = new ConfigTransformerKernel();
        $configTransformerKernel->boot();

        $this->container = $configTransformerKernel->getContainer();
    }
}
