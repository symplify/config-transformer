<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter;

use PhpParser\Node;

interface KeyYamlToPhpFactoryInterface
{
    public function getKey(): string;

    /**
     * @param mixed[] $yaml
     * @return Node[]
     */
    public function convertYamlToNodes(array $yaml): array;
}
