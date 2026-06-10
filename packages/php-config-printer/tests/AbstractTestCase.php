<?php

declare(strict_types=1);

namespace Symplify\PhpConfigPrinter\Tests;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symplify\PhpConfigPrinter\Tests\HttpKernel\TestKernel;

abstract class AbstractTestCase extends TestCase
{
    private ContainerInterface $container;

    protected function setUp(): void
    {
        $testKernel = new TestKernel('test', true);
        $testKernel->boot();

        $this->container = $testKernel->getContainer();
    }

    /**
     * @template TType as object
     *
     * @param class-string<TType> $type
     * @return TType
     */
    public function getService(string $type): object
    {
        if (! $this->container->has($type)) {
            throw new RuntimeException(sprintf('Service "%s" not found in container.', $type));
        }

        return $this->container->get($type);
    }
}
