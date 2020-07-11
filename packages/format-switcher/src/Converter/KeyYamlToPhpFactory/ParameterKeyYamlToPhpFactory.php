<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\KeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use PhpParser\Node;

final class ParameterKeyYamlToPhpFactory implements KeyYamlToPhpFactoryInterface
{
    public function getKey(): string
    {
        return 'parameters';
    }

    /**
     * @param mixed[] $yaml
     * @return Node[]
     */
    public function convertYamlToNodes(array $yaml): array
    {
        return [];
    }
}
