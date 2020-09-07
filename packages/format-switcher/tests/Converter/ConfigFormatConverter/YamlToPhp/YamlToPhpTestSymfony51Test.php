<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Tests\Converter\ConfigFormatConverter\YamlToPhp;

use Iterator;
use Migrify\ConfigTransformer\FormatSwitcher\Configuration\Configuration;
use Migrify\ConfigTransformer\FormatSwitcher\Tests\Converter\ConfigFormatConverter\AbstractConfigFormatConverterTest;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\Format;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\SmartFileSystem\SmartFileInfo;

final class YamlToPhpTestSymfony51Test extends AbstractConfigFormatConverterTest
{
    protected function setUp(): void
    {
        parent::setUp();

        /** @var Configuration $configuration */
        $configuration = self::$container->get(Configuration::class);
        $configuration->changeSymfonyVersion(5.1);
    }

    /**
     * @dataProvider provideData()
     */
    public function test(SmartFileInfo $fixtureFileInfo): void
    {
        $this->doTestOutput($fixtureFileInfo, Format::YAML, Format::PHP);
    }

    public function provideData(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/FixtureSymfony51', '*.yaml');
    }
}
