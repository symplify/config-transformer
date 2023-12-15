<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Converter\ConfigFormatConverter\XmlToPhp;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use Symplify\ConfigTransformer\Tests\Converter\ConfigFormatConverter\AbstractConfigFormatConverterTestCase;
use Symplify\ConfigTransformer\Tests\Helper\FixtureFinder;

final class XmlToPhpTest extends AbstractConfigFormatConverterTestCase
{
    #[DataProvider('provideData')]
    public function test(\SplFileInfo $fixtureFileInfo): void
    {
        $this->smartFileSystem->copy(
            __DIR__ . '/Source/some.xml',
            sys_get_temp_dir() . '/_temp_fixture_easy_testing/some.xml'
        );

        $this->doTestOutput($fixtureFileInfo);
    }

    public static function provideData(): Iterator
    {
        return FixtureFinder::yieldDirectory(__DIR__ . '/Fixture', '*.xml');
    }
}
