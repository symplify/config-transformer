<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter;

use PhpParser\Node\Stmt\Expression;

interface CaseConverterInterface
{
    public function match(string $rootKey, $key, $values): bool;

    /**
     * @param mixed[] $values
     */
    public function convertToMethodCall(string $key, $values): Expression;
}
