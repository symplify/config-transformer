<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\Clarifier\Tests\Clarifier\NeonYamlConfigClarifier;

use Iterator;
use Migrify\ConfigTransformer\Clarifier\Clarifier\NeonYamlConfigClarifier;
use Migrify\ConfigTransformer\HttpKernel\ConfigTransformerKernel;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\EasyTesting\StaticFixtureSplitter;
use Symplify\PackageBuilder\Tests\AbstractKernelTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;

final class NeonYamlConfigClarifierTest extends AbstractKernelTestCase
{
    /**
     * @var NeonYamlConfigClarifier
     */
    private $neonYamlConfigClarifier;

    protected function setUp(): void
    {
        $this->bootKernel(ConfigTransformerKernel::class);
        $this->neonYamlConfigClarifier = self::$container->get(NeonYamlConfigClarifier::class);
    }

    /**
     * @dataProvider provideData()
     */
    public function test(SmartFileInfo $fileInfo): void
    {
        $inputAndExpected = StaticFixtureSplitter::splitFileInfoToInputAndExpected($fileInfo);

        $changedContent = $this->neonYamlConfigClarifier->clarify(
            $inputAndExpected->getInput(),
            $fileInfo->getSuffix()
        );
        $this->assertSame($inputAndExpected->getExpected() . PHP_EOL, $changedContent);
    }

    public function provideData(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture', '*.neon');
    }
}
