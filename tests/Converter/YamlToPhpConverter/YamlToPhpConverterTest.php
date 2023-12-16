<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Converter\YamlToPhpConverter;

use Symplify\ConfigTransformer\Converter\YamlToPhpConverter;
use Symplify\ConfigTransformer\Tests\AbstractTestCase;

final class YamlToPhpConverterTest extends AbstractTestCase
{
    public function test(): void
    {
        $yamlToPhpConverter = $this->getService(YamlToPhpConverter::class);

        $printedPhpConfigContent = $yamlToPhpConverter->convertYamlArray([
            'parameters' => [
                'key' => 'value',
                'format' => '\d+',
            ],
        ], 'file_path.yaml');

        $this->assertStringEqualsFile(__DIR__ . '/Fixture/expected_parameters.php', $printedPhpConfigContent);
    }
}
