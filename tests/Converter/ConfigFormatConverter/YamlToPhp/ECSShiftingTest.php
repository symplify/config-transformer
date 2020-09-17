<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\Tests\Converter\ConfigFormatConverter\YamlToPhp;

use Iterator;
use Migrify\ConfigTransformer\Tests\Converter\ConfigFormatConverter\AbstractConfigFormatConverterTest;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ECSShiftingTest extends AbstractConfigFormatConverterTest
{
    /**
     * @dataProvider provideData()
     */
    public function testComments(SmartFileInfo $fixtureFileInfo): void
    {
        $this->doTestOutput($fixtureFileInfo, 'yaml', 'php');
    }

    public function provideData(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture/ecs-shifting', '*.yaml');
    }
}
