<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter;

use PhpParser\Node;

interface ServiceKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed[] $yaml
     */
    public function convertYamlToNode($key, $yaml): Node;

    public function isMatch($key, $values): bool;
}
