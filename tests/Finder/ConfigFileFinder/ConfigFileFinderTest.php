<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Finder\ConfigFileFinder;

use Symplify\ConfigTransformer\Finder\ConfigFileFinder;
<<<<<<< HEAD
<<<<<<< HEAD
use Symplify\ConfigTransformer\Kernel\ConfigTransformerKernel;
=======
use Symplify\ConfigTransformer\Tests\AbstractTestCase;
>>>>>>> cd67f40 (bump)
use Symplify\ConfigTransformer\ValueObject\Configuration;

final class ConfigFileFinderTest extends AbstractTestCase
{
    private ConfigFileFinder $configFileFinder;

    protected function setUp(): void
    {
        $this->configFileFinder = $this->container->get(ConfigFileFinder::class);
    }

=======
use Symplify\ConfigTransformer\Tests\AbstractTestCase;

/**
 * @see \Symplify\ConfigTransformer\Finder\ConfigFileFinder
 */
final class ConfigFileFinderTest extends AbstractTestCase
{
>>>>>>> 8c52b6b (fixup! fixup! fixup! fixup! fixup! fixup! bump)
    public function test(): void
    {
        $configFileFinder = new ConfigFileFinder();
        ;

        $fileInfos = $configFileFinder->findFileInfos([__DIR__ . '/Fixture']);
        $this->assertCount(1, $fileInfos);
    }
}
