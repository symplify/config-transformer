<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\ConfigClarity\Tests\Clarifier\NeonYamlConfigClarifier;

use Iterator;
use Migrify\ConfigTransformer\ConfigClarity\Clarifier\NeonYamlConfigClarifier;
use Migrify\ConfigTransformer\ConfigClarity\HttpKernel\ConfigClarityKernel;
use Nette\Utils\Strings;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
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
        $this->bootKernel(ConfigClarityKernel::class);
        $this->neonYamlConfigClarifier = self::$container->get(NeonYamlConfigClarifier::class);
    }

    /**
     * @dataProvider provideData()
     */
    public function test(SmartFileInfo $fileInfo): void
    {
        [$inputContent, $expectedContent] = Strings::split($fileInfo->getContents(), "#-----\n#");

        $changedContent = $this->neonYamlConfigClarifier->clarify($inputContent, $fileInfo->getSuffix());
        $this->assertSame($expectedContent . PHP_EOL, $changedContent);
    }

    public function provideData(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture', '*.neon');
    }
}
