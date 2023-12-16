<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Finder\ConfigFileFinder;

use PHPUnit\Framework\TestCase;
use Symplify\ConfigTransformer\Finder\ConfigFileFinder;

/**
 * @see \Symplify\ConfigTransformer\Finder\ConfigFileFinder
 */
final class ConfigFileFinderTest extends TestCase
{
    public function test(): void
    {
        $configFileFinder = new ConfigFileFinder();

        $fileInfos = $configFileFinder->findFileInfos([__DIR__ . '/Fixture']);
        $this->assertCount(1, $fileInfos);
    }
}
