<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter;

use PhpParser\Node\Stmt\Expression;

interface ServiceKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed[] $yaml
     */
    public function convertYamlToNode($key, $yaml): Expression;

    public function isMatch($key, $values): bool;
}
