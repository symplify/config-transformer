<?php

declare(strict_types=1);

namespace Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
use Symplify\PhpConfigPrinter\Tests\AbstractTestCase;
use Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\ClassWithConstants;
use Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\FirstClass;
use Symplify\PhpConfigPrinter\Tests\Printer\SmartPhpConfigPrinter\Source\SecondClass;

final class SmartPhpConfigPrinterTest extends AbstractTestCase
{
    private SmartPhpConfigPrinter $smartPhpConfigPrinter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->smartPhpConfigPrinter = $this->getService(SmartPhpConfigPrinter::class);
    }

    /**
     * @param array<class-string, mixed[]> $services
     */
    #[DataProvider('provideData')]
    public function test(array $services, string $expectedContentFilePath): void
    {
        $printedContent = $this->smartPhpConfigPrinter->printConfiguredServices($services);
        $this->assertStringEqualsFile($expectedContentFilePath, $printedContent, $expectedContentFilePath);
    }

    public static function provideData(): Iterator
    {
        yield [[
            FirstClass::class => [
                'some_key' => 'some_value',
            ],
            SecondClass::class => null,
        ], __DIR__ . '/Fixture/expected_file.php.inc'];

        yield [[
            ClassWithConstants::class => [
                ClassWithConstants::CONFIG_KEY => 'it is constant',
                ClassWithConstants::NUMERIC_CONFIG_KEY => 'a lot of numbers',
            ],
        ], __DIR__ . '/Fixture/expected_constant_file.php.inc'];
    }
}
