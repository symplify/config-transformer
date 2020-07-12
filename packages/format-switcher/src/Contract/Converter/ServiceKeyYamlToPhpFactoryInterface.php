<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter;

use PhpParser\Node;

interface ServiceKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed[] $yaml
     * @return Node[]
     */
    public function convertYamlToNodes($key, $yaml): array;

    public function isMatch($key, $values): bool;
}
