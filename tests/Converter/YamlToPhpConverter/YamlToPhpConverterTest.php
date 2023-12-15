<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Tests\Converter\YamlToPhpConverter;

use Symplify\ConfigTransformer\Converter\YamlToPhpConverter;
use Symplify\ConfigTransformer\Tests\AbstractTestCase;

final class YamlToPhpConverterTest extends AbstractTestCase
{
    private YamlToPhpConverter $yamlToPhpConverter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->yamlToPhpConverter = $this->container->get(YamlToPhpConverter::class);
    }

    public function test(): void
    {
        $printedPhpConfigContent = $this->yamlToPhpConverter->convertYamlArray([
            'parameters' => [
                'key' => 'value',
            ],
        ], 'file_path.yaml');

        $this->assertStringEqualsFile(__DIR__ . '/Fixture/expected_parameters.php', $printedPhpConfigContent);
    }
}
